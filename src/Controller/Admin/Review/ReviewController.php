<?php

namespace App\Controller\Admin\Review;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class ReviewController extends AbstractController
{
    #[Route('/review/list', name: 'admin.review.index')]
    public function index(ReviewRepository $reviewRepository): Response
    {
        $reviews = $reviewRepository->findAll();
        return $this->render('pages/admin/review/index.html.twig', [
            'reviews' => $reviews
        ]);
    }

    // Route pour la suppression d'un Avis. Avec la methode DELETE(pour utiliser la methode PUT et DELETE, il faut que http_method_override et handle_all_throwables soient sur TRUE dans le fichier config/packages/framework.yaml)
    #[Route('/review/{id}/delete', name: 'admin.review.delete', methods: ['DELETE'])]
    public function delete(Review $review, Request $request, EntityManagerInterface $em): Response
    {
        // si le token de sécurité est valide
        if ($this->isCsrfTokenValid('delete_review_' . $review->getId(), $request->request->get('csrf_token'))) {
            // on prepare la requete de suppression de la commande
            $em->remove($review);
            //  on envoie la requete
            $em->flush();
            // on retourne un message de success
            $this->addFlash('success', 'La commande a été supprimée avec succès');
        }
        // on redirige vers la page des réservations
        return $this->redirectToRoute('admin.review.index');
    }
}
