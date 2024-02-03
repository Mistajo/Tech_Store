<?php

namespace App\Controller\Admin\Product;

use App\Entity\Image;
use App\Entity\Product;
use App\Form\ProductFormType;
use App\Service\FileUploader;
use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class ProductController extends AbstractController
{
    #[Route('/product', name: 'admin.product.index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('pages/admin/product/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/product/list', name: 'admin.product.list.index')]
    public function productlist(ProductRepository $productRepository, ImageRepository $imageRepository): Response
    {
        $products = $productRepository->findAll();
        $images = $imageRepository->findAll();
        return $this->render('pages/admin/product/list.html.twig', [
            'products' => $products,
            'images' => $images,
        ]);
    }


    #[Route('/product/create', name: 'admin.product.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepository, FileUploader $fileUploader): Response
    {
        if (count($categoryRepository->findAll()) == 0) {
            $this->addFlash("warning", "Vous devez créer au moins une catégorie avant de créer un produit.");
            return $this->redirectToRoute('admin.category.index');
        }
        $product = new Product($fileUploader);
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                $filename = $fileUploader->upload($image);
                $newImage = new Image();
                $newImage->setFilename($filename);
                $product->addImage($newImage);
                $images = $product->getImages();
                $em->persist($newImage);
            }
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Le produit a été ajoutée avec succès.');
            return $this->redirectToRoute('admin.product.list.index');
        }
        return $this->render("pages/admin/product/create.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/{id}/edit', name: 'admin.product.edit', methods: ['GET', 'PUT'])]
    public function edit(Product $product, Request $request, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(ProductFormType::class, $product, [
            "method" => "PUT"
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Gestion des images
            $images = $form->get('images')->getData();

            if (!empty($images)) {
                // Suppression des anciennes images
                foreach ($product->getImages() as $image) {
                    $em->remove($image);
                    $fileUploader->remove($image->getFilename());
                }
                $product->getImages()->clear();

                // Ajout des nouvelles images
                foreach ($images as $image) {
                    $filename = $fileUploader->upload($image);

                    $newImage = new Image();
                    $newImage->setFilename($filename);
                    $product->addImage($newImage);
                    $images = $product->getImages();
                    $em->persist($newImage);
                }
            }

            $em->persist($product);
            $em->flush();

            $this->addFlash("success", "Le produit a été modifié avec succès.");
            return $this->redirectToRoute('admin.product.list.index');
        }

        return $this->render("pages/admin/product/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }


    public function deleteImage(Request $request, FileUploader $fileUploader, ImageRepository $imageRepository, EntityManagerInterface $em): Response
    {
        $imageId = $request->request->get('image_id');
        $image = $imageRepository->find($imageId);

        if (!$image) {
            throw $this->createNotFoundException('Image not found');
        }

        // Remove image from product
        $product = $image->getProduct();
        $product->removeImage($image);

        // Remove image from database and server

        $em->remove($image);
        $em->flush();

        $fileUploader->remove($image->getFilename());

        return new JsonResponse(['success' => true]);
    }

    #[Route('/product/pc-portables', name: 'admin.product_pc_portables.list')]
    public function pcPortables(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('PC Portables');

        if (empty($products)) {

            $this->addFlash('warning', "Il n'y pas de produit dans cette catégorie");
        }

        return $this->render('pages/admin/product/pc_portables.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/pc-de-bureau', name: 'admin.product_pc_bureau.list')]
    public function pcBureau(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('PC de Bureau');

        if (empty($products)) {

            $this->addFlash('warning', "Il n'y pas de produit dans cette catégorie");
        }

        return $this->render('pages/admin/product/pc_bureau.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/ecrans', name: 'admin.product_ecran.list')]
    public function ecran(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('Ecrans');

        if (empty($products)) {

            $this->addFlash('warning', "Il n'y pas de produit dans cette catégorie");
        }


        return $this->render('pages/admin/product/ecran.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/imprimantes', name: 'admin.product_imprimante.list')]
    public function imprimante(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('Imprimantes');

        if (empty($products)) {

            $this->addFlash('warning', "Il n'y pas de produit dans cette catégorie");
        }


        return $this->render('pages/admin/product/imprimante.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/encres_et_toners', name: 'admin.product_encre_toner.list')]
    public function encresToner(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('Encre et Toner');

        if (empty($products)) {

            $this->addFlash('warning', "Il n'y pas de produit dans cette catégorie");
        }


        return $this->render('pages/admin/product/encre_et_toner.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}/delete', name: 'admin.product.delete', methods: ['DELETE'])]
    public function delete(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid("delete_product_" . $product->getId(), $request->request->get('csrf_token'))) {
            $em->remove($product);
            $em->flush();

            $this->addFlash("success", "Cette catégorie ainsi que tous ses articles ont été supprimés.");
        }

        return $this->redirectToRoute('admin.product.index');
    }
}