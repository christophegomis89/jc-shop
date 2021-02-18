<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Produits;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }
    /**
     * @Route("/produits", name="produits")
     */
    public function index(Request $request): Response
    {
      
          $search = new Search();
           

         $form = $this->createForm(SearchType::class, $search);

         $form->handleRequest($request);
         
         if($form->isSubmitted() && $form->isValid()){
            $produits =$this->em->getRepository(Produits::class)->findWithSearch($search);
         }
         else{
            $produits = $this->em->getRepository(Produits::class)->findAll();

         }
            
        

        return $this->render('produit/index.html.twig',[

            'produits'=> $produits,
            'form'=> $form->createView()
            
        ]);
        
    }
    
    /**
     * @Route("/produit/{slug}", name="produit")
     */
    public function show($slug): Response
    {
        
        $produit = $this->em->getRepository(Produits::class)->findOneBySlug($slug);
        $produits = $this->em->getRepository(Produits::class)->findByIsBest(1);


              if(!$produit){

                return $this->redirectToRoute('produits');

              }
           
        return $this->render('produit/show.html.twig',[

            'produit'=> $produit,
            'produits'=>$produits
        ]);
        
    }
}
