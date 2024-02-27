<?php

namespace App\Controller\Admin\Order;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
class OrderController extends AbstractController
{
    #[Route('/order/list', name: 'admin.order.index')]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        return $this->render('pages/admin/order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    // Route pour la suppression d'une commande. Avec la methode DELETE(pour utiliser la methode PUT et DELETE, il faut que http_method_override et handle_all_throwables soient sur TRUE dans le fichier config/packages/framework.yaml)
    #[Route('/order/{id}/delete', name: 'admin.order.delete', methods: ['DELETE'])]
    public function delete(Order $order, Request $request, EntityManagerInterface $em): Response
    {
        // si le token de sécurité est valide
        if ($this->isCsrfTokenValid('delete_order_' . $order->getId(), $request->request->get('csrf_token'))) {
            // on prepare la requete de suppression de la commande
            $em->remove($order);
            //  on envoie la requete
            $em->flush();
            // on retourne un message de success
            $this->addFlash('success', 'La commande a été supprimée avec succès');
        }
        // on redirige vers la page des réservations
        return $this->redirectToRoute('admin.order.index');
    }

    // Route pour la suppression d'une réservation multiple. Avec la methode DELETE(pour utiliser la methode PUT et DELETE, il faut que http_method_override et handle_all_throwables soient sur TRUE dans le fichier config/packages/framework.yaml)
    #[Route('/orders/multiple-orders-delete', name: 'admin.orders.multiple_delete', methods: ['DELETE'])]
    public function multipleDelete(
        Request $request,
        OrderRepository $orderRepository,
        EntityManagerInterface $em
    ): Response {
        // on récupere la valeur du token
        $csrfTokenValue = $request->request->get('csrf_token');
        // si le token n'est pas valide 
        if (!$this->isCsrfTokenValid("multiple_delete_orders_token_key", $csrfTokenValue)) {
            // pn retourne un message d'erreur
            return $this->json(
                ['status' => false, "message" => "Un problème est survenu, veuillez réessayer."],
                Response::HTTP_BAD_REQUEST
            );
        }
        // dans le cas contraire
        // on récupères les ids
        $ids = $request->request->get('ids');
        // on transforme les ids en tableau de chaine de caractère
        $ids = explode(",", $ids);
        // pour chaque id
        foreach ($ids as $id) {
            // on récupère la réservation
            $order = $orderRepository->findOneBy(['id' => $id]);
            // on prepare la requete de suppression de la réservation
            $em->remove($order);
            // on exexute la requete
            $em->flush();
        }
        // on retourne un message de success
        return $this->json(['status' => true, "message" => "La suppression multiple a été effectuée avec succès."]);
    }
}
