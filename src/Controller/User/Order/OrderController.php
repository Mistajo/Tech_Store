<?php

namespace App\Controller\User\Order;

use Stripe\Price;
use Stripe\Stripe;
use App\Entity\Order;
use Stripe\PaymentIntent;
use App\Form\OrderFormType;
use App\Entity\OrderProduct;
use App\Service\CartService;
use Stripe\Checkout\Session;
use App\Repository\OrderRepository;
use App\Repository\CarrierRepository;
use App\Repository\PaymentRepository;
use App\Repository\AddressesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrderProductRepository;

use PayPalCheckoutSdk\Core\PayPalHttpClient;

use Symfony\Component\HttpFoundation\Request;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SebastianBergmann\ObjectReflector\Exception;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class OrderController extends AbstractController

{

    // private function getAuthAssertionValue($clientId, $sellerPayerId)
    // {
    //     $header = [
    //         "alg" => "none",
    //     ];
    //     $encodedHeader = $this->base64url(json_encode($header));

    //     $payload = [
    //         "iss" => $clientId,
    //         "payer_id" => $sellerPayerId,
    //     ];
    //     $encodedPayload = $this->base64url(json_encode($payload));

    //     return "{$encodedHeader}.{$encodedPayload}.";
    // }

    // private function base64url($json)
    // {
    //     $base64 = base64_encode($json);
    //     $base64url = str_replace(['+', '/', '='], ['-', '_', ''], $base64);
    //     return $base64url;
    // }

    public function getPaypalClient(): PayPalHttpClient
    {
        $clientId = ($_ENV['Paypal_CLIENT_ID']);
        $clientSecret = ($_ENV['Paypal_CLIENT_SECRET']);
        $environment = new SandboxEnvironment($clientId, $clientSecret);
        return new PayPalHttpClient($environment);
    }


    #[Route('/order/create', name: 'user.order.create')]
    public function index(CartService $cartService, Request $request, EntityManagerInterface $em): Response
    {
        $order = new Order();
        $user = $this->getUser();
        $cart = $cartService->getCart();
        $total = $cartService->getTotalCart($cart);

        $form = $this->createForm(OrderFormType::class, null, [
            'user' => $user,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $datetime = new \DateTime();
            $reference = 'FA' . $datetime->format('Ymd') . '-' . uniqid();
            $carrier = $form->get('carriers')->getData();
            $address = $form->get('addresses')->getData();
            $carrierPrice = $carrier->getPrice();
            $newtotal = $total += $carrierPrice;
            $order->setReference($reference)
                ->setUser($user)
                ->setCarrier($carrier)
                ->setCarrierName($carrier->getName())
                ->setCarrierPrice($carrierPrice)
                ->setAddresses($address)
                ->setTotalPayable($newtotal);
            $em->persist($order);

            foreach ($cartService->getCart() as $product) {
                $orderProduct = new OrderProduct;
                $orderProduct->setProduct($product['product'])
                    ->setOrders($order)
                    ->setProductName($product['product']->getName())
                    ->setQuantity($product['quantity'])
                    ->setPrice($product['product']->getPrice()) // Utiliser l'objet Product pour récupérer le prix
                    ->setTotalRecap($product['product']->getPrice() * $product['quantity']); // Calculer le total du produit
                $em->persist($orderProduct);
            }
            try {
                $em->flush();
                $cartService->removeCartAll(); // Supprimer tous les produits du panier
                return $this->redirectToRoute('user.order.choice.payment', ['reference' => $reference]);
            } catch (\Exception $e) {
                $this->addFlash("warning", "Votre commande n'a pas été validée.");
                return $this->redirectToRoute('visitor.cart.index');
            }

            // $em->flush();

            // return $this->redirectToRoute('user.order.choice.payment', ['reference' => $reference]);
        }

        return $this->render('pages/user/order/index.html.twig', [
            'cart' => $cart,
            'total' => $total,
            'form' => $form,
            'order' => $order

        ]);
    }

    #[Route('/order/Choice-Payment', name: 'user.order.choice.payment')]
    public function choicePayment(CartService $cartService, OrderRepository $orderRepository, Request $request, PaymentRepository $paymentRepository, OrderProductRepository $orderProductRepository): Response
    {
        $reference = $request->query->get('reference');
        $order = $orderRepository->findOneBy(['reference' => $reference]);
        $cart = $cartService->getCart();

        $carrierPrice = $request->query->get('carrierPrice');
        $payments = $paymentRepository->findAll();
        $orderProducts = $orderProductRepository->findAll();
        return $this->render('pages/user/payment/choicepayment.html.twig', [
            'cart' => $cart,
            'order' => $order,
            'carrierPrice' => $carrierPrice,
            'payments' => $payments,
            'orderProducts' => $orderProducts,
            'current_order' => $order
        ]);
    }

    #[Route('/order/{paymentSlug}/{reference}', name: 'user.order.payment')]
    public function StripePayment($paymentSlug, $reference, EntityManagerInterface $em, UrlGeneratorInterface $generator, OrderRepository $orderRepository): RedirectResponse
    {

        $order = $orderRepository->findOneBy(['reference' => $reference]);
        if (!$order) {
            throw $this->createNotFoundException("La commande demandée n'existe pas.");
        }

        // Rediriger vers la méthode Stripe pour le paiement Carte Bancaire
        if ($paymentSlug === 'par-carte-bancaire') {
            Stripe::setApiKey($_ENV['Stripe_API_SECRET']);
            $price = Price::create([
                'unit_amount' => $order->getTotalPayable() * 100, // Total amount multiplied by 100 (in cents)
                'currency' => 'EUR', // Use your preferred currency (e.g., 'eur', 'usd')
                'product_data' => [
                    'name' => 'Commande N° #' . $order->getReference(),
                ],
            ]);
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'mode' => 'payment',
                'line_items' => [[
                    'price' => $price->id,
                    'quantity' => 1,
                ]],
                'success_url' => $generator->generate('user.payment.success', [
                    'reference' => $order->getReference(),
                    'userid' => $order->getUser()->getId(),
                ], UrlGeneratorInterface::ABSOLUTE_URL),

                'cancel_url' => $generator->generate('user.order.choice.payment', [
                    'reference' => $order->getReference(),
                    'userid' => $order->getUser()->getId(),
                ], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);
            $order->setMethodOfPayment('Card');
            $order->setStripeSessionId($checkout_session->id);
            $em->flush();
            return new RedirectResponse($checkout_session->url);
        } elseif ($paymentSlug == 'par-paypal') {
            // Rediriger vers la méthode PaypalPayment pour le paiement Paypal
            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'EUR',
                            'value' => $order->getTotalPayable(),
                        ]
                    ]
                ],
                'application_context' => [
                    'return_url' => $generator->generate('user.payment.success', [
                        'reference' => $order->getReference(),
                        'userid' => $order->getUser()->getId(),
                    ], UrlGeneratorInterface::ABSOLUTE_URL),

                    'cancel_url' => $generator->generate(
                        'user.order.choice.payment',
                        [
                            'reference' => $order->getReference(),
                            'userid' => $order->getUser()->getId(),
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    ),
                ]
            ];
            $client = $this->getPaypalClient();

            $response = $client->execute($request);

            if ($response->statusCode != 201) {
                return $this->redirectToRoute('user.order.choice.payment');
            }

            $approvalLink = '';
            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    $approvalLink = $link->href;
                    break;
                }
            }
            if (empty($approvalLink)) {
                return $this->redirectToRoute('user.order.choice.payment');
            }
            $order->setMethodOfPayment('Paypal');
            $order->setPaypalSessionId($response->result->id);
            $em->flush();
            return new RedirectResponse($approvalLink);
        } else {
            // Si le type de paiement n'est pas reconnu, renvoyer une erreur 404
            throw $this->createNotFoundException("Type de paiement non reconnu.");
        }
    }


    #[Route('/order/{reference}', name: 'user.payment.success')]
    public function paymentSuccess($reference, EntityManagerInterface $em, OrderRepository $orderRepository, Request $request)
    {

        $order = $orderRepository->findOneBy(['reference' => $reference]);
        if (!$order) {
            throw $this->createNotFoundException("La commande demandée n'existe pas.");
        }
        if (!$order->isIsPaid()) {

            if ($order->getMethodOfPayment() === 'Card') {
                Stripe::setApiKey($_ENV['Stripe_API_SECRET']);
                $checkout_session = \Stripe\Checkout\Session::retrieve($order->getStripeSessionId());
                if ($checkout_session->payment_intent) {
                    $paymentIntent = PaymentIntent::retrieve($checkout_session->payment_intent);

                    if ($paymentIntent->status === 'succeeded') {
                        $order->setIsPaid(true);
                        $em->flush();
                        $this->addFlash("success", "Merci pour votre commande.");
                        // Rediriger vers une autre page
                        return $this->redirectToRoute('user.home.index');
                    }
                }
            } elseif ($order->getMethodOfPayment() === 'Paypal') {
                $captureRequest = new OrdersCaptureRequest($order->getPaypalSessionId());
                $captureRequest->prefer('return=representation');
                $client = $this->getPaypalClient();
                $response = $client->execute($captureRequest);

                if ($response->statusCode === 201 && $response->result->status === 'COMPLETED') {
                    $order->setIsPaid(true);
                    $em->flush();
                    $this->addFlash("success", "Merci pour votre commande.");
                    // Rediriger vers une autre page
                    return $this->redirectToRoute('user.home.index');
                }
                if ($response->statusCode != 201) {
                    $this->addFlash("warning", "Le paiement a ete annulé.");
                    return $this->redirectToRoute('user.order.choice.payment');
                }
            }
            // Si le paiement n'a pas été capturé ou n'a pas réussi, rediriger l'utilisateur vers la page d'erreur de paiement.
            $this->addFlash("warning", "Le paiement a été annulé.");
            return $this->redirectToRoute('user.home.index');
        } else {
            // Si le paiement a déjà été effectué, renvoyer un message flash pour l'indiquer et rediriger l'utilisateur vers une autre page.
            $this->addFlash("warning", "La commande a déjà été payée.");
            // Rediriger vers une autre page
            return $this->redirectToRoute('user.home.index');
        }
        return $this->render('pages/user/home/index.html.twig', []);
    }
}
