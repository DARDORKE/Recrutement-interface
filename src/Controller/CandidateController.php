<?php

namespace App\Controller;

use App\Form\EmailUpdateFormType;
use App\Form\PasswordUpdateFormType;
use App\Form\UpdateCandidateFormType;
use App\Form\UpdateRecruiterFormType;
use App\Repository\JobOfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CandidateController extends AbstractController
{
    #[Route('/candidate', name: 'app_candidate')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SluggerInterface $slugger, JobOfferRepository $jobOfferRepository) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_CANDIDATE');

        $candidate = $this->getUser();

        $form = $this->createForm(UpdateCandidateFormType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $cvFile */
            $cvFile = $form->get('cv')->getData();

            // this condition is needed because the 'cv' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($cvFile) {
                $originalFilename = pathinfo($cvFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$cvFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $cvFile->move(
                        $this->getParameter('app.path.candidate_cvs'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $candidate->setCv($newFilename);
            }

            $entityManager->persist($candidate);
            $entityManager->flush();
        }

        $form2 = $this->createForm(PasswordUpdateFormType::class, $candidate);
        $form2->handleRequest($request);

        if ($form2->isSubmitted() && $form2->isValid()) {
            // encode the plain password
            $candidate->setPassword(
                $userPasswordHasher->hashPassword(
                    $candidate,
                    $form2->get('plainPassword')->getData()
                ));

            $entityManager->persist($candidate);
            $entityManager->flush();
        }

        $form3 = $this->createForm(EmailUpdateFormType::class, $candidate);
        $form3->handleRequest($request);
        if ($form3->isSubmitted() && $form3->isValid()) {
            $entityManager->persist($candidate);
            $entityManager->flush();
        }

        return $this->render('candidate/index.html.twig', [
            'updateAccountForm' => $form->createView(),
            'passwordUpdateForm' => $form2->createView(),
            'emailUpdateForm' => $form3->createView(),
            'job_offers' => $jobOfferRepository->findAll(),
        ]);
    }

    #[Route('/candidate/apply/{id}', name: 'app_candidate_apply')]
    public function apply(Request $request, EntityManagerInterface $entityManager, JobOfferRepository $jobOfferRepository,int $id) : Response
    {
        $this->denyAccessUnlessGranted('ROLE_CANDIDATE');

        $candidate = $this->getUser();

        $jobOffer = $jobOfferRepository->find($id);
        $candidate->addJobOffer($jobOffer);

        $entityManager->persist($candidate);
        $entityManager->flush();

        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }
}
