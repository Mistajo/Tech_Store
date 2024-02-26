<?php

namespace App\Controller\Visitor\Welcome;

use App\Entity\Review;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\ReviewFormType;
use App\Repository\ImageRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WelcomeController extends AbstractController
{
    #[Route('/', name: 'visitor.welcome.index')]
    public function index(ProductRepository $productRepository, ImageRepository $imageRepository, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $images = $imageRepository->findAll();
        $products = $productRepository->findAll();
        return $this->render('pages/visitor/welcome/index.html.twig', [
            'products' => $products,
            'images' => $images,
            'categories' => $categories,
        ]);
    }

    #[Route('/pc-portables', name: 'visitor.product_pc_portables.list')]
    public function pcPortables(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('PC Portables');

        if (empty($products)) {

            $this->addFlash('warning', "Il n'y pas de produit dans cette catégorie");
        }

        return $this->render('pages/visitor/welcome/product/pc_portables.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/pc-de-bureau', name: 'visitor.product_pc_bureau.list')]
    public function pcBureau(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('PC de Bureau');

        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }

        return $this->render('pages/visitor/product/pc_bureau.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/ecrans', name: 'visitor.product_ecran.list')]
    public function ecran(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('Ecrans');

        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }


        return $this->render('pages/visitor/product/ecran.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/imprimantes', name: 'visitor.product_imprimante.list')]
    public function imprimante(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('Imprimantes');

        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }


        return $this->render('pages/visitor/product/imprimante.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/encre-et-toner', name: 'visitor.product_encre_toner.list')]
    public function encresToner(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('Encre et Toner');

        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }


        return $this->render('pages/visitor/product/encre_et_toner.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/souris', name: 'visitor.product_souris.list')]
    public function souris(ProductRepository $productRepository)
    {
        $products = $productRepository->findByCategory('Souris');


        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }


        return $this->render('pages/visitor/product/mousse.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/claviers', name: 'visitor.product_claviers.list')]
    public function claviers(ProductRepository $productRepository,)
    {
        $products = $productRepository->findByCategory('Claviers');


        if (empty($products)) {

            $this->addFlash('warning', "Aucun produit dans cette catégorie");
        }


        return $this->render('pages/visitor/product/keyboard.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/products/{id}/show', name: 'visitor.product_show')]
    public function show(Product $product, ImageRepository $imageRepository, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $image = $imageRepository->findAll();
        // Récupération des données du formulaire
        $rating = $request->request->get('rating');
        $comment = $request->request->get('comment');

        // // Vérification des données
        // if (!$rating || !$comment) {
        //     // Affichage d'un message d'erreur ou de redirection vers la page précédente
        //     $this->addFlash('warning', 'Veuillez remplir le commentaire et donner une note');
        // } else {
        //     $review = new Review();
        //     $review->setRating($rating);
        //     $review->setContent($comment);
        //     $review->setAuthor($user);
        //     $review->setProduct($product);
        //     $em->persist($review);
        //     $em->flush();
        //     $this->addFlash('success', 'Votre Avis a été pris en compte');
        //     return $this->redirectToRoute('visitor.product_show', ['id' => $product->getId()]);
        // }


        return $this->render('pages/visitor/welcome/show.html.twig', [
            'product' => $product,
            'image' => $image,
            'user' => $user
        ]);
    }
}