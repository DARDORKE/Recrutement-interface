<?php

namespace App\Controller;

use App\Entity\Recruiter;
use App\Form\EmailUpdateFormType;
use App\Form\PasswordUpdateFormType;
use App\Form\RegistrationRecruiterFormType;
use App\Form\UpdateRecruiterFormType;
use App\Security\AppAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RecruiterController extends AbstractController
{
    #[Route('/recruiter', name: 'app_recruiter')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_RECRUITER');

        $recruiter = $this->getUser();

        $form = $this->createForm(UpdateRecruiterFormType::class, $recruiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($recruiter);
            $entityManager->flush();
        }

        $form2 = $this->createForm(PasswordUpdateFormType::class, $recruiter);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            // encode the plain password
            $recruiter->setPassword(
                $userPasswordHasher->hashPassword(
                    $recruiter,
                    $form2->get('plainPassword')->getData()
                ));

            $entityManager->persist($recruiter);
            $entityManager->flush();
        }

        $form3 = $this->createForm(EmailUpdateFormType::class, $recruiter);
        $form3->handleRequest($request);
        if ($form3->isSubmitted() && $form3->isValid()) {
            $entityManager->persist($recruiter);
            $entityManager->flush();
        }


        return $this->render('recruiter/index.html.twig', [
            'updateAccountForm' => $form->createView(),
            'passwordUpdateForm' => $form2->createView(),
            'emailUpdateForm' => $form3->createView()
        ]);
    }
}
