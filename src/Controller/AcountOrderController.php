<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AcountOrderController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        
    }
    /**
     * @Route("/compte/mes-commandes", name="acount_order")
     */
    public function index(): Response
    {

        $orders = $this->em->getRepository( Order::class)->findSuccessOrders($this->getUser());

         
        return $this->render('acount/order.html.twig',[

            'orders'=> $orders
        ]);
    }

    /**
     * @Route("/compte/mes-commandes/{reference}", name="acount_order_show")
     */
    public function show($reference): Response
    {

        $order = $this->em->getRepository( Order::class)->findOneByReference($reference);

         if(!$order || $order->getUser() != $this->getUser()){
             return $this->redirectToRoute('acount_order');
         }
        return $this->render('acount/order_show.html.twig',[

            'order'=> $order
        ]);
    }
}
