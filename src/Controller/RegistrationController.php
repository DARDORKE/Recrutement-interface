<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Recruiter;
use App\Entity\User;
use App\Form\RegistrationCandidateFormType;
use App\Form\RegistrationFormType;
use App\Form\RegistrationRecruiterFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register_ask')]
    public function registerRedirect(): Response
    {
        return $this->render('registration/register_redirect.html.twig');
    }

    #[Route('/register/recruiter', name: 'app_register_recruiter')]
    public function registerRecruiter(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $recruiter = new Recruiter();
        $form = $this->createForm(RegistrationRecruiterFormType::class, $recruiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $recruiter->setPassword(
                $userPasswordHasher->hashPassword(
                    $recruiter,
                    $form->get('plainPassword')->getData()
                )
            )->setRoles(['ROLE_RECRUITER'])
            ;

            $entityManager->persist($recruiter);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $recruiter,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register_recruiter.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/register/candidate', name: 'app_register_candidate')]
    public function registerCandidate(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $candidate = new Candidate();
        $form = $this->createForm(RegistrationCandidateFormType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $candidate->setPassword(
                $userPasswordHasher->hashPassword(
                    $candidate,
                    $form->get('plainPassword')->getData()
                )
            )->setRoles(['ROLE_CANDIDATE'])
            ;

            $entityManager->persist($candidate);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $candidate,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register_candidate.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
