<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderValidateController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index( Cart $cart,$stripeSessionId): Response
    {
        $order = $this->em->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if(!$order|| $order->getUser()!= $this->getUser()){

            return $this->redirectToRoute('gomis');
        }
       
        if($order->getState() == 0){
        //  vider la session 'cart'
        $cart->remove();
         $order->setState(1);
         $this->em->flush();
        //Envoyer un mail au client pour lui connfirmer sa commande
        }

        
        // Afficher les quelques informations de la commande de l'utilisateur
        return $this->render('order_validate/index.html.twig',[
            'order'=>$order
        ]);
    }
}
