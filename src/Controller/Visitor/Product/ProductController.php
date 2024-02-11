<?php

namespace App\Controller\Visitor\Product;

use App\Entity\Product;
use App\Service\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product/cart', name: 'visitor.product.index')]
    public function index(): Response
    {
        return $this->render('pages/visitor/product/index.html.twig');
    }

    #[Route('/product/{id}/show', name: 'visitor.product.show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('pages/visitor/product/show.html.twig', [
            'product' => $product,
        ]);
    }
}
