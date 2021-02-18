<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="contact")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);
         if($form->isSubmitted()&& $form->isValid()){

            $this->addFlash('notice', 'Merci de nous avoir contacter , notre équipe vous répondra dans les méilleurs délais');

            // $mail = new Mail
            // $mail->send()
         }
        return $this->render('contact/index.html.twig',[

            'form'=>$form->createView()
        ]);
    }
}
