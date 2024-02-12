<?php

// src/Service/CartService.php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $requestStack;
    private $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
    }


    public function addToCart($id, $quantity)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }
        $this->getSession()->set('cart', $cart);
    }


    public function addFromCart($id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $this->getSession()->set('cart', $cart);
    }

    public function getCart()
    {
        $cart = $this->getSession()->get('cart', []);
        $cartData = [];
        if ($cart) {
            foreach ($cart as $id => $quantity) {
                $product = $this->em->getRepository(Product::class)->findOneBy(['id' => $id]);
                if (!$product) {
                    continue; // Ignore this product and move to the next one
                }
                $cartData[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }
        }
        return $cartData;
    }


    public function removeFromCart($id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id]--;
            if ($cart[$id] <= 0) {
                unset($cart[$id]);
            }
            $this->getSession()->set('cart', $cart);
        }
    }

    public function removeProduct($id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            unset($cart[$id]);
        }
        $this->getSession()->set('cart', $cart);
    }


    public function removeCartAll()
    {
        $this->getSession()->remove('cart');
    }



    public function getTotalCart(array $cart): int
    {
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['product']->getPrice();
        }

        return $total;
    }

    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }
}
