<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Entity\SubCategory;
use App\Form\CategoryFormType;
use App\Form\SubCategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class CategoryController extends AbstractController
{
    #[Route('/category/list', name: 'admin.category.index')]
    public function index(CategoryRepository $categoryRepository,): Response
    {

        $categories = $categoryRepository->findAll();
        return $this->render('pages/admin/category/index.html.twig', [
            "categories" => $categories,

        ]);
    }

    #[Route('/catetory/create', name: 'admin.category.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            $this->addFlash("success", "La catégorie a été ajoutée avec succès.");
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render("pages/admin/category/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route('/catetory/{id}/edit', name: 'admin.category.edit', methods: ['GET', 'PUT'])]
    public function edit($id, Category $category, Request $request, EntityManagerInterface $em, CategoryRepository $categoryRepository): Response
    {


        $form = $this->createForm(CategoryFormType::class, $category, [
            "method" => "PUT",

        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($category);
            $em->flush();

            $this->addFlash("success", "La catégorie a été modifiée avec succès.");
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render("pages/admin/category/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }


    #[Route('/catetory/{id}/delete', name: 'admin.category.delete', methods: ['DELETE'])]
    public function delete(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid("delete_category_" . $category->getId(), $request->request->get('csrf_token'))) {
            $em->remove($category);
            $em->flush();

            $this->addFlash("success", "Cette catégorie ainsi que tous ses articles ont été supprimés.");
        }

        return $this->redirectToRoute('admin.category.index');
    }
}
