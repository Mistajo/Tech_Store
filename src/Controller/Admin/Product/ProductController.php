<?php

namespace App\Controller\Admin\Product;

use App\Entity\Image;
use App\Entity\Product;
use App\Entity\SubCategory;
use App\Form\ProductFormType;
use App\Service\FileUploader;
use App\Service\PictureService;
use App\Service\ProductService;
use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
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
    public function create(Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepository, ProductService $productService): Response
    {
        if (count($categoryRepository->findAll()) == 0) {
            $this->addFlash("warning", "Vous devez créer au moins une catégorie avant de créer un produit.");
            return $this->redirectToRoute('admin.category.index');
        }
        $product = new Product();

        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $files = $form->get('images')->getData();

            $imageNames = $productService->uploadImages($files);

            foreach ($imageNames as $imageName) {
                $productService->createThumbnail($imageName);
            }

            $productService->create($product, $imageNames);

            $this->addFlash('success', 'Le produit a été ajoutée avec succès.');
            return $this->redirectToRoute('admin.product.list.index');
        }
        return $this->render("pages/admin/product/create.html.twig", [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    #[Route('/product/{id}/edit', name: 'admin.product.edit', methods: ['GET', 'PUT'])]
    public function edit(Product $product, Request $request, EntityManagerInterface $em, ProductService $productService): Response
    {

        $form = $this->createForm(ProductFormType::class, $product, [
            "method" => "PUT"
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $files = $form->get('images')->getData();
            $imageNames = $productService->uploadImages($files);

            foreach ($imageNames as $imageName) {
                $productService->createThumbnail($imageName);
            }

            $productService->update($product, $imageNames);

            $this->addFlash("success", "Le produit a été modifié avec succès.");
            return $this->redirectToRoute('admin.product.list.index');
        }

        return $this->render("pages/admin/product/edit.html.twig", [
            "form" => $form->createView(),
            "product" => $product,
            'productService' => $productService,
        ]);
    }


    #[Route('/pc-portables', name: 'admin.product_pc_portables.list')]
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

    #[Route('/pc-de-bureau', name: 'admin.product_pc_bureau.list')]
    public function pcBureau(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('PC de Bureau');

        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }

        return $this->render('pages/admin/product/pc_bureau.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/ecrans', name: 'admin.product_ecran.list')]
    public function ecran(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('Ecrans');

        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }


        return $this->render('pages/admin/product/ecran.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/imprimantes', name: 'admin.product_imprimante.list')]
    public function imprimante(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('Imprimantes');

        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }


        return $this->render('pages/admin/product/imprimante.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/encre-et-toner', name: 'admin.product_encre_toner.list')]
    public function encresToner(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('Encre et Toner');

        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }


        return $this->render('pages/admin/product/encre_et_toner.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/souris', name: 'admin.product_souris.list')]
    public function souris(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('Souris');


        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }


        return $this->render('pages/admin/product/mousse.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/claviers', name: 'admin.product_claviers.list')]
    public function claviers(ProductRepository $productRepository,)
    {
        $products = $productRepository->findByCategory('Claviers');


        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }


        return $this->render('pages/admin/product/keyboard.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/image/{id}/delete', name: 'admin.image.delete', methods: ['DELETE'])]
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid("delete_image_" . $image->getId(), $request->request->get('csrf_token'))) {
            $em->remove($image);
            $em->flush();

            $this->addFlash("success", "Cette image a été supprimée.");
        }

        return $this->redirectToRoute('admin.product.edit', ['id' => $image->getProduct()->getId()]);
    }



    #[Route('/product/{id}/delete', name: 'admin.product.delete', methods: ['DELETE'])]
    public function delete(Product $product, Request $request, EntityManagerInterface $em, ProductService $productService): Response
    {
        if ($this->isCsrfTokenValid("delete_product_" . $product->getId(), $request->request->get('csrf_token'))) {
            foreach ($product->getImages() as $imageName) {
                $imagePath = $productService->getProductImagePath($imageName);
                $thumbnailPath = $productService->getProductThumbnailPath($imageName);

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }

                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath);
                }
            }

            $productService->delete($product);


            $this->addFlash("success", "Ce produit a été supprimé.");
        }

        return $this->redirectToRoute('admin.product.list.index');
    }
}