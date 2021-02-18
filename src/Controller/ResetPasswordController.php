<?php

namespace App\Controller;

use App\Entity\User;

use App\Entity\ResetPassword;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/mot-de-passe oublié ", name="reset_password")
     */
    public function index(Request $request): Response
    {
        if($this->getUser()){

            return $this->redirectToRoute('gomis');
        }

        if($request->get('email')){

          $user = $this->em->getRepository(User::class)->findOneByEmail($request->get('email'));

          if($user){
            //   Enregidtrer en base la demande de mot de passe oublié avec user, token , createdAt
              $reset_password = new ResetPassword();
              $reset_password->setUser($user);
              $reset_password->setToken(uniqid());
              $reset_password->setCreatedAt(new \DateTime());

              $this->em->persist($reset_password);
              $this->em->flush();

            //   Envoyer un email à l'utilisateur lui permettant de modifier son mot de passe
              // $url = $this->generateUrl('update_password', [

              //   'token'=>$motPassOublie->getToken()
              // ]);

              // $content = "Bonjour".$user->getPrenom()."</br> Vous avez demander à réinitialiser votre mot de passe.</br></br>";
              // $content .= "Merci  de bien vouloir cliquer sur ce lien <a href ='".$url."'>pour mettre à jour votre mot de passe .</a>";
              // $mail = new Mail();
              // $mail->send($user->getEmail(), $user->getPrenom(). ''.$user->getNom(), 'Réinitialiser votre mot de passe.' , $content);

              $this->addFlash('notice','Vous allez recevoir un mail de réinitialisation de votre mot de passe');
          }else{
             $this->addFlash('notice','Cette adresse email est inconnue');
          }
        }
        return $this->render('reset_password/index.html.twig');
    }
    /**
     * @Route("/modifier-mon-mot-de-passe/{token}", name="update_password")
     */
    public function update( Request $request, $token)
    {
      $reset_password = $this->em->getRepository(ResetPassword::class)->findOneByToken($token);

      if(!$reset_password){

        return  $this->redirectToRoute('reset_password');
      }

      // Verifier si le createdAt est égal à maintenant -2h
      $now = new \DateTime();
     if($now > $reset_password->getCreatedAt()->modify('+3 hour')){

      $this->addFlash('notice', 'Votre mot de passe a expiré. Merci de la renouveler!');

      return $this->redirectToRoute('reset_passwor');
     }

    //  Rendre une vue avec mot de passe oublié
    $form = $this->createForm(ResetPasswordType::class);
    $form->handleRequest($request);
    if($form->isSubmitted()&& $form->isValid()){

    }

    return $this->render('reset_password/update.html.twig',[

      'form'=>$form->createView()
    ]);

    // Encodage des mots de passe 
    // Flush en base de donnéées
    // Redirection de l'utilisateur vers la page de connexion
     

    }
}
