<?php

namespace App\Controller\Visitor\Welcome;

use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'visitor.welcome.index')]
    public function index(ProductRepository $productRepository, ImageRepository $imageRepository): Response
    {
        $images = $imageRepository->findAll();
        $products = $productRepository->findAll();
        return $this->render('pages/visitor/welcome/index.html.twig', [
            'products' => $products,
            'images' => $images,
        ]);
    }
}
