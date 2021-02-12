<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Adresse;
use App\Form\AdresseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;

class AcountAdresseController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        
    }
    /**
     * @Route("/compte/adresse", name="acount_adresse")
     */
    public function index(): Response
    {
              
        return $this->render('acount/adresse.html.twig');
    }

    /**
     * @Route("/compte/ajouter-une-adresse", name="acount_adresse_add")
     */
    public function add(Cart $cart,Request $request): Response
    { 
        $adresse = new Adresse();

        $form = $this->createForm(AdresseType::class, $adresse );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $adresse->setUser($this->getUser());

          $this->em->persist($adresse);

          $this->em->flush();
          if($cart->get()){

            return $this->redirectToRoute('order');
          }else{
              return $this->redirectToRoute('acount_adresse');
          }

      }
        return $this->render('acount/adresse_form.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="acount_adresse_edit")
     */
    public function edit(Request $request, $id): Response
    { 
        $adresse = $this->em->getRepository(Adresse::class,)->findOneById($id);

        if(!$adresse || $adresse->getUser() != $this->getUser()){
            return $this->redirectToRoute('acount_adresse');
        }

        $form = $this->createForm(AdresseType::class, $adresse );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

          $this->em->flush();

         return $this->redirectToRoute('acount_adresse');
        }
        return $this->render('acount/adresse_form.html.twig',[
            'form'=>$form->createView()
        ]);
    }
     /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="acount_adresse_delete")
     */
    public function delete($id): Response
    { 
        $adresse = $this->em->getRepository(Adresse::class,)->findOneById($id);

        if($adresse && $adresse->getUser() == $this->getUser()){
            $this->em->remove($adresse);
            $this->em->flush();
        }          
         
       return $this->redirectToRoute('acount_adresse');
            
    }
}
