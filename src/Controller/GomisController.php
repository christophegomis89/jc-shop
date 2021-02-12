<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GomisController extends AbstractController
{
    /**
     * @Route("/", name="gomis")
     */
    public function index(): Response
    {
        return $this->render('gomis/index.html.twig');
    }
}
