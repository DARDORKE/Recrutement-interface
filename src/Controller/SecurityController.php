<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        if (!(is_null($user))) {
            if (in_array('ROLE_ADMIN' , $user->getRoles())) {
                return $this->redirectToRoute('admin');
            }

            if (in_array('ROLE_CONSULTANT' , $user->getRoles())) {
                return $this->redirectToRoute('admin');
            }

            if (in_array('ROLE_RECRUITER' , $user->getRoles())) {
                return $this->redirectToRoute('app_recruiter');
            }

            if (in_array('ROLE_CANDIDATE' , $user->getRoles())) {
                return $this->redirectToRoute('app_candidate');
            }
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
