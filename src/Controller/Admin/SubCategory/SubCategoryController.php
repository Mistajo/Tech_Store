<?php

namespace App\Controller\Admin\SubCategory;

use App\Entity\SubCategory;
use App\Form\SubCategoryFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class SubCategoryController extends AbstractController
{
    #[Route('/sub-category/list', name: 'admin.sub_category.index')]
    public function index(SubCategoryRepository $subCategoryRepository): Response
    {
        $subcategories = $subCategoryRepository->findAll();
        return $this->render('pages/admin/sub_category/index.html.twig', [
            'subcategories' => $subcategories,
        ]);
    }

    #[Route('/sub_category/create', name: 'admin.sub_category.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $subcategory = new SubCategory();

        $form = $this->createForm(SubCategoryFormType::class, $subcategory);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($subcategory);
            $em->flush();

            $this->addFlash("success", "La sous catégorie a été ajoutée avec succès.");
            return $this->redirectToRoute('admin.sub_category.index');
        }

        return $this->render("pages/admin/sub_category/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route('/sub_category/{id}/edit', name: 'admin.sub_category.edit', methods: ['GET', 'PUT'])]
    public function edit(SubCategory $subcategory, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SubCategoryFormType::class, $subcategory, [
            "method" => "PUT"
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($subcategory);
            $em->flush();

            $this->addFlash("success", "La sous catégorie a été modifiée avec succès.");
            return $this->redirectToRoute('admin.sub_category.index');
        }

        return $this->render("pages/admin/sub_category/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }


    #[Route('/sub-catetory/{id}/delete', name: 'admin.sub_category.delete', methods: ['DELETE'])]
    public function delete(SubCategory $subcategory, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid("delete_subcategory_" . $subcategory->getId(), $request->request->get('csrf_token'))) {
            $em->remove($subcategory);
            $em->flush();

            $this->addFlash("success", "Cette sous catégorie a été supprimée.");
        }

        return $this->redirectToRoute('admin.sub_category.index');
    }
}
