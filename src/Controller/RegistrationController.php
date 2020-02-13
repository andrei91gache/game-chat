<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * La route elle cree avec annotations faire gaffe donc la
     * @Route("/registration", name="registration", methods={"GET","POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager): Response
    {
        //Creer un formulaire a partir d un objet, pour ca l'objet doit etre associes dans un formtype /src/From
        $user = new User();
        //Creer formulaire
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        //Si le form a ete transmis et valide par formtype
        if ($form->isSubmitted() && $form->isValid()) {
            // encoder le mot de passe parce que il en claire
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            //persiter l utilisateur et sauvgarder
            $entityManager->persist($user);
            $entityManager->flush();

            //Ensuite rediriger vers un page ex: login
            return $this->redirectToRoute('home_page');
        }

        //Juste pour afficher page inscription
        return $this->render('registration/index.html.twig', [
            'registrationForm' => $form->createView()
        ]);
    }
}
