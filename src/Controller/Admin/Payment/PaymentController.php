<?php

namespace App\Controller\Admin\Payment;

use App\Entity\Payment;
use App\Form\PaymentFormType;
use App\Repository\PaymentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class PaymentController extends AbstractController
{
    #[Route('/method-of-payment/list', name: 'admin.payment.index')]
    public function index(PaymentRepository $paymentRepository): Response
    {
        $payments = $paymentRepository->findAll();
        return $this->render('pages/admin/payment/index.html.twig', [
            'payments' => $payments,
        ]);
    }

    #[Route('/payment/create', name: 'admin.payment.create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $payment = new Payment();

        $form = $this->createForm(PaymentFormType::class, $payment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($payment);
            $em->flush();

            $this->addFlash("success", "Le mode de paiement a été ajouté avec succès.");
            return $this->redirectToRoute('admin.payment.index');
        }

        return $this->render("pages/admin/payment/create.html.twig", [
            "form" => $form->createView()
        ]);
    }

    #[Route('/payment/{id}/edit', name: 'admin.payment.edit', methods: ['GET', 'PUT'])]
    public function edit($id, Payment $payment, Request $request, EntityManagerInterface $em, PaymentRepository $paymentRepository): Response
    {


        $form = $this->createForm(PaymentFormType::class, $payment, [
            "method" => "PUT",

        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em->persist($payment);
            $em->flush();

            $this->addFlash("success", "Le mode de paiement a été modifié avec succès.");
            return $this->redirectToRoute('admin.payment.index');
        }

        return $this->render("pages/admin/payment/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }


    #[Route('/payment/{id}/delete', name: 'admin.payment.delete', methods: ['DELETE'])]
    public function delete(Payment $payment, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid("delete_payment_" . $payment->getId(), $request->request->get('csrf_token'))) {
            $em->remove($payment);
            $em->flush();

            $this->addFlash("success", "Ce mode de paiement a été supprimé.");
        }

        return $this->redirectToRoute('admin.payment.index');
    }
}
