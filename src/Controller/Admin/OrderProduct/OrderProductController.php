<?php

namespace App\Controller\Admin\OrderProduct;

use App\Entity\OrderProduct;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrderProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderProductController extends AbstractController
{
    #[Route('/order/product/details', name: 'admin.order.details.index')]
    public function index(OrderProductRepository $orderProductRepository): Response
    {
        $ordersProducts = $orderProductRepository->findAll();
        return $this->render('pages/admin/order_product/index.html.twig', [
            'ordersProducts' => $ordersProducts
        ]);
    }

    // Route pour la suppression du detail de la commande. Avec la methode DELETE(pour utiliser la methode PUT et DELETE, il faut que http_method_override et handle_all_throwables soient sur TRUE dans le fichier config/packages/framework.yaml)
    #[Route('/orderProduct/{id}/delete', name: 'admin.orderProduct.delete', methods: ['DELETE'])]
    public function delete(OrderProduct $orderProduct, Request $request, EntityManagerInterface $em): Response
    {
        // si le token de sécurité est valide
        if ($this->isCsrfTokenValid('delete_orderProduct_' . $orderProduct->getId(), $request->request->get('csrf_token'))) {
            // on prepare la requete de suppression du detail de la commande
            $em->remove($orderProduct);
            //  on envoie la requete
            $em->flush();
            // on retourne un message de success
            $this->addFlash('success', 'Le détail de la commande a été supprimé avec succès');
        }
        // on redirige vers la page des réservations
        return $this->redirectToRoute('admin.order.details.index');
    }
}
