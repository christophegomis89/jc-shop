<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPwController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em){

        $this->em = $em;

    }
    /**
     * @Route("/compte/modifier mot-de-passe", name="acount_pw")
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;

        $user =$this->getUser();

        $form = $this->createForm(ChangePasswordType::class,$user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 

            $old_pw = $form->get('old_password')->getData();
             
            if($encoder->isPasswordValid($user,$old_pw)){
                $new_pw = $form->get('new_password')->getData();
             
                $password = $encoder->encodePassword($user,$new_pw);

                $user->setPassword($password);

                $this->em->flush();

                $notification = 'Votre mot de passe a bien été modofié';
            }else{
                $notification = 'Votre mot de passe n\'est pas valide';
            }
            
        }

        return $this->render('acount/password.html.twig',[
            'form'=>$form->createView(),

            'notification'=>$notification
        ]);
    }
}
