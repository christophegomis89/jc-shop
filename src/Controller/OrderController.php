<?php

namespace App\Controller;

use DateTime;
use Stripe\Stripe;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Adresse;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    private $em;


    public function __construct(EntityManagerInterface $em)
    { $this->em = $em;
        
    }
    /**
     * @Route("/commande", name="order")
     */
    public function index(Request $request,Cart $cart): Response
    {
         if(!$this->getUser()->getAdresses()->getValues())
         {
             return $this->redirectToRoute('acount_adresse_add');
         }

        $form = $this->createForm(OrderType::class, null, [

            'user'=>$this->getUser()
        ]);
       
        return $this->render('order/index.html.twig',[

            'form'=>$form->createView(),

            'cart'=>$cart->getFull()
        ]);
    }

     /**
     * @Route("/commande/recapitulatif", name="order_recap", methods = {"POST"})
     */
    public function add(Request $request,Cart $cart): Response
    {
        $form = $this->createForm(OrderType::class, null, [

            'user'=>$this->getUser()
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            
            
            $date = new dateTime();

            $carriers = $form->get('carriers')->getData();

            $delivery = $form->get('adressses')->getData();

           
            
            
           $delivery_content = $delivery->getPrenom() . '' . $delivery->getNom();

          
           $delivery_content .= '<br/>'.$delivery->getTelephone();

           if($delivery->getEntreprise()){

            $delivery_content .= '<br/>'.$delivery->getEntreprise();
           }
           $delivery_content .= '<br/>'.$delivery->getAdresse();

           $delivery_content .= '<br/>'.$delivery->getcodePostal(). ''.$delivery->getVille();

           $delivery_content .= '<br/>'.$delivery->getPays();

           $delivery_content .= '<br/>'.$delivery->getNomaDresse();
           
         
            // enregistrer ma commande order    
            $order = new Order();
            $reference= $date->format('dmY').'-'.uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getNom());
            $order->setCarrierPrix($carriers->getPrix());
            $order->setDelivery($delivery_content);
            $order->setState(0);

            $this->em->persist($order);

            
            // enregistrer mes produits Order_details
            
            foreach($cart->getFull() as $produit){

                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduit($produit['produit']->getNom());
                $orderDetails->setQuantity($produit['quantity']);
                $orderDetails->setPrix($produit['produit']->getPrix());
                $orderDetails->setTotal($produit['produit']->getPrix() *$produit['quantity']);
                $this->em->persist($orderDetails);
             
              }
                                   
                $this->em->flush();
                           
           }
            return $this->render('order/add.html.twig',[
            'cart'=>$cart->getFull(),
            'carrier'=>$carriers,
            'delivery'=>$delivery_content,
            'reference'=>$order->getReference()
           
        ]);

        return $this->redirectToRoute('cart');
    }
   
  }
