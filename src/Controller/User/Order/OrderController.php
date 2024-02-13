<?php

namespace App\Controller\User\Order;

use App\Form\OrderFormType;
use App\Repository\AddressesRepository;
use App\Repository\CarrierRepository;
use App\Service\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class OrderController extends AbstractController
{
    #[Route('/order/create', name: 'user.order.create')]
    public function index(CartService $cartService, AddressesRepository $addressesRepository, CarrierRepository $carrierRepository): Response
    {

        $user = $this->getUser();
        $addresses = $addressesRepository->findBy(['user' => $user]);
        $carriers = $carrierRepository->findAll();
        $cart = $cartService->getCart();
        $total = $cartService->getTotalCart($cart);

        $form = $this->createForm(OrderFormType::class, null, [
            'addresses' => $addresses,
            'carriers' => $carriers
        ]);


        return $this->render('pages/user/order/index.html.twig', [
            'cart' => $cart,
            'total' => $total,
            'form' => $form,
            'addresses' => $addresses,
            'carriers' => $carriers
        ]);
    }
}
