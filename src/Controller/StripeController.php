<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Produits;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create_session/{reference}", name="stripe_create_session")
     */
    public function index(EntityManagerInterface $em, Cart $cart, $reference)
    {
        $produits_for_stripe = [];
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
       
        $order = $em
            ->getRepository(Order::class)
            ->findOneByReference($reference);

        if (!$order) {
            new JsonResponse(['error' => 'order']);
        }

        foreach ($order->getOrderDetails()->getValues() as $produit) {
            $produit_object = $em
                ->getRepository(Produits::class)
                ->findOneByNom($produit->getProduit());

            $produits_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $produit->getPrix(),
                    'product_data' => [
                        'name' => $produit->getProduit(),
                        'images' => [
                            $YOUR_DOMAIN .
                            '/uploads/' .
                            $produit_object->getullistration(),
                        ],
                    ],
                ],
                'quantity' => $produit->getQuantity(),
            ];
        }
         
        $produits_for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrix(),
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN],
                ],
            ],
            'quantity' => 1,
        ];
        

        Stripe::setApiKey(
            'sk_test_51IJGeHJnYtUU6dNMIK2Z5HpmvKaTMHVfGfLoQMF5a4PilBXPTrVwT0F4qOHqUHX25ZvisvOaRBXSoZnI4ayhfbzP0061kTVdxs'
        );

        $checkout_session = Session::create([
            'customer_email'=>$this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [[$produits_for_stripe]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);

        $order->setStripeSessionId($checkout_session->id);
        $em->flush();
        $response = new JsonResponse(['id' => $checkout_session->id]);

        return $response;
    }
}
