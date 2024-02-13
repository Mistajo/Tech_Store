<?php

namespace App\Controller\Admin\Carrier;

use App\Entity\Carrier;
use App\Form\CarrierFormType;
use App\Repository\CarrierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class CarrierController extends AbstractController
{
    #[Route('/carrier/list', name: 'admin.carrier.index')]
    public function index(CarrierRepository $carrierRepository): Response
    {
        $carriers = $carrierRepository->findAll();
        return $this->render('pages/admin/carrier/index.html.twig', [
            'carriers' => $carriers,
        ]);
    }

    #[Route('/carrier/create', name: 'admin.carrier.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $carrier = new Carrier();

        $form = $this->createForm(CarrierFormType::class, $carrier);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($carrier);
            $em->flush();

            $this->addFlash("success", "Le transporteur a été ajouté avec succès.");
            return $this->redirectToRoute('admin.carrier.index');
        }

        return $this->render("pages/admin/carrier/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route('/carrier/{id}/edit', name: 'admin.carrier.edit', methods: ['GET', 'PUT'])]
    public function edit($id, Carrier $carrier, Request $request, EntityManagerInterface $em, CarrierRepository $carrierRepository): Response
    {


        $form = $this->createForm(CarrierFormType::class, $carrier, [
            "method" => "PUT",

        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($carrier);
            $em->flush();

            $this->addFlash("success", "Le transporteur a été modifié avec succès.");
            return $this->redirectToRoute('admin.carrier.index');
        }

        return $this->render("pages/admin/carrier/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }


    #[Route('/carrier/{id}/delete', name: 'admin.carrier.delete', methods: ['DELETE'])]
    public function delete(Carrier $carrier, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid("delete_carrier_" . $carrier->getId(), $request->request->get('csrf_token'))) {
            $em->remove($carrier);
            $em->flush();

            $this->addFlash("success", "Ce transporteur a été supprimé.");
        }

        return $this->redirectToRoute('admin.carrier.index');
    }
}
