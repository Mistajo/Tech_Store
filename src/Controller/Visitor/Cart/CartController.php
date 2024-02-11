<?php

namespace App\Controller\Visitor\Cart;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'visitor.cart.index')]
    public function index(CartService $cartService): Response
    {
        $cart = $cartService->getCart();
        $total = $cartService->getTotalCart($cart);


        return $this->render('pages/visitor/cart/index.html.twig', [
            'cart' => $cart,
            'total' => $total,
        ]);
    }

    #[Route('/cart/{id<\d+>}/add', name: 'visitor.cart.add')]
    public function add($id, Request $request, CartService $cartService, Product $product): Response
    {
        $cartService->addToCart($id);

        $this->addFlash('success', "Le produit {$product->getName()} a bien été ajouté au panier");

        return $this->redirectToRoute('visitor.product.show', [
            'slug' => $product->getSlug(),
            'id' => $product->getId(),
        ]);
    }

    #[Route('/cart/{id<\d+>}/add/cart', name: 'visitor.cart.product.add')]
    public function addInCart($id, Request $request, CartService $cartService, Product $product): Response
    {
        $cartService->addToCart($id);

        $this->addFlash('success', "Le produit {$product->getName()} a bien été ajouté au panier");

        return $this->redirectToRoute('visitor.cart.index', [
            'slug' => $product->getSlug(),
            'id' => $product->getId(),
        ]);
    }

    #[Route('/cart/removeAll', name: 'visitor.cart.removeall')]
    public function removeAll(CartService $cartService): Response
    {
        $cartService->removeCartAll();

        $this->addFlash('success', "Votre panier a bien été vidé");

        return $this->redirectToRoute('visitor.cart.index');
    }

    #[Route('/cart/{id}/remove', name: 'visitor.cart.remove')]
    public function remove($id, Request $request, CartService $cartService, Product $product): Response
    {
        $cartService->removeFromCart($id);

        $this->addFlash('warning', "Le produit {$product->getName()} a bien été supprimé du panier");

        return $this->redirectToRoute('visitor.cart.index', [
            'slug' => $product->getSlug(),
            'id' => $product->getId(),
        ]);
    }
}
