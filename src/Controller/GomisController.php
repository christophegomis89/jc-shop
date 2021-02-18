<?php

namespace App\Controller;

use App\Entity\Header;
use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GomisController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/", name="gomis")
     */
    public function index(): Response
    {

        $produits = $this->em->getRepository(Produits::class)->findByIsBest(1);

        $headers = $this->em->getRepository(Header::class)->findAll();
        return $this->render('gomis/index.html.twig', [

            'produits'=> $produits,
            'headers'=>$headers
        ]);
    }
}
