<?php

namespace App\Controller\User\Order;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Form\OrderFormType;
use App\Service\CartService;
use App\Repository\CarrierRepository;
use App\Repository\AddressesRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class OrderController extends AbstractController
{
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
            $reference = $datetime->format('dmYHis') . '-' . uniqid();
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
                    ->setQuantity($product['quantity'])
                    ->setPrice($product['product']->getPrice()) // Utiliser l'objet Product pour récupérer le prix
                    ->setTotalRecap($product['product']->getPrice() * $product['quantity']); // Calculer le total du produit
                $em->persist($orderProduct);
            }

            $em->flush();
            return $this->redirectToRoute('user.order.choice.payment', ['reference' => $reference]);
        }

        return $this->render('pages/user/order/index.html.twig', [
            'cart' => $cart,
            'total' => $total,
            'form' => $form,
            'order' => $order

        ]);
    }

    #[Route('/order/Choice-Payment', name: 'user.order.choice.payment')]
    public function choicePayment(CartService $cartService, OrderRepository $orderRepository, CarrierRepository $carrierRepository, Request $request): Response
    {
        $reference = $request->query->get('reference');
        $order = $orderRepository->findOneBy(['reference' => $reference]);
        $cart = $cartService->getCart();
        $total = $cartService->getTotalCart($cart);
        $carrierPrice = $request->query->get('carrierPrice');


        return $this->render('pages/user/payment/choicepayment.html.twig', [
            'cart' => $cart,
            'total' => $total,
            'order' => $order,
            'carrierPrice' => $carrierPrice,
        ]);
    }
}
