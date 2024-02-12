<?php

namespace App\Controller\User\Addresses;

use App\Entity\Addresses;
use App\Form\AddressesFormType;
use App\Repository\AddressesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class AddressesController extends AbstractController
{
    #[Route('/addresses', name: 'user.addresses.index')]
    public function index(AddressesRepository $addressesRepository): Response
    {
        $addresses = $addressesRepository->findBy(['user' => $this->getUser()], ['updatedAt' => 'DESC']);
        return $this->render('pages/user/addresses/index.html.twig', [
            'addresses' => $addresses
        ]);
    }

    #[Route('/addresses/create', name: 'user.addresses.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em,): Response
    {
        $user = $this->getUser();
        $addresses = new Addresses();
        $form = $this->createForm(AddressesFormType::class, $addresses);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $addresses->setUser($user);
            // Enregistrer les modifications
            $em->persist($addresses);
            $em->flush();
            $this->addFlash("success", "L'adresse a bien été crée.");
            return $this->redirectToRoute('user.addresses.index');
        }

        return $this->render('pages/user/addresses/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/addresses/edit/{id}', name: 'user.addresses.edit', methods: ['GET', 'PUT'])]
    public function edit(Addresses $addresses, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(AddressesFormType::class, $addresses, [
            'method' => 'PUT'
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $addresses->setUser($user);
            $em->persist($$addresses);
            $em->flush();
            $this->addFlash("success", "L'adresse a bien été modifiée.");
            return $this->redirectToRoute('user.addresses.index');
        }
        return $this->render('pages/user/addresses/edit.html.twig', [
            'form' => $form->createView(),
            'addresses' => $$addresses
        ]);
    }

    #[Route('/addresses/delete/{id}', name: 'user.addresses.delete', methods: ['DELETE'])]
    public function delete(Addresses $addresses, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid("delete_addresses_" . $addresses->getId(), $request->request->get("csrf_token"))) {
            // On prepare la requete de suppression de l'agence
            $em->remove($addresses);
            // on envois la requete
            $em->flush();
            // on affiche un message de succès
            $this->addFlash("success", "L'adresse a bien été supprimée.");
            // on redirige vers la page d'accueil des agences
            return $this->redirectToRoute("user.addresses.index");
        }
        return $this->render('pages/user/addresses/index.html.twig');
    }
}
