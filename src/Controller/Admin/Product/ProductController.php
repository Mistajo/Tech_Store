<?php

namespace App\Controller\Admin\Product;

use App\Entity\Product;
use App\Form\ProductFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class ProductController extends AbstractController
{
    #[Route('/product/list', name: 'admin.product.index')]
    public function index(): Response
    {
        return $this->render('pages/admin/product/index.html.twig');
    }

    #[Route('/Product/create', name: 'admin.product.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepository): Response
    {
        if (count($categoryRepository->findAll()) == 0) {
            $this->addFlash("warning", "Vous devez créer au moins une catégorie avant de créer un produit.");
            return $this->redirectToRoute('admin.category.index');
        }
        $product = new Product();

        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Le produit a été ajoutée avec succès.');
            return $this->redirectToRoute('admin.product.index');
        }
        return $this->render("pages/admin/product/create.html.twig", [
            'form' => $form->createView(),
        ]);
    }
}
