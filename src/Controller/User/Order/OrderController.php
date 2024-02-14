<?php

namespace App\Controller\User\Order;

use App\Entity\Order;
use App\Form\OrderFormType;
use App\Service\CartService;
use App\Repository\CarrierRepository;
use App\Repository\AddressesRepository;
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
            $carrier = $form->get('carrier')->getData();
            $address = $form->get('address')->getData();
            dd($address);
            $order->setReference($reference)
                ->setUser($user)
                ->setCarrier($carrier->getName())
                ->setCarrierPrice($carrier->getPrice())
                ->setAddresses($address);
            $em->persist($order);
            $em->flush();
            // return $this->redirectToRoute('app_order_show', ['reference' => $reference]);
        }


        return $this->render('pages/user/order/index.html.twig', [
            'cart' => $cart,
            'total' => $total,
            'form' => $form,

        ]);
    }
}
