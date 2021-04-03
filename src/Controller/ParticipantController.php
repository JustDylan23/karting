<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\UserFormType;
use App\Repository\ActivityRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/user/activities", name="app_activities")
     */
    public function activitiesVue(): Response
    {
        return $this->render('vue_user.html.twig');
    }

    /**
     * @Route("/user/profile", name="app_profile")
     */
    public function profile(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->plainPassword) {
                $user->setPassword($passwordEncoder->encodePassword($user, $user->plainPassword));
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_profile');
        }
        return $this->render('deelnemer/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/api/user/activities")
     */
    public function activitiesApi(ActivityRepository $repository): Response
    {
        return $this->json([
            'available' => $repository->getAvailableActivities($this->getUser()->getId()),
            'registered' => $repository->getRegisteredActivities($this->getUser()->getId()),
        ]);
    }

    /**
     * @Route("/api/user/registrations/{id}", methods={"POST"})
     */
    public function createRegistration(Activity $activity, EntityManagerInterface $entityManager): Response
    {
        if ($activity->getMaxRegistrations() > $activity->getTotalUsers() && $activity->getDatetime() > new DateTime('today')) {
            $activity->addUser($this->getUser());
        }
        $entityManager->flush();

        return new Response(Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/user/registrations/{id}", methods={"DELETE"})
     */
    public function removeRegistration(Activity $activity, EntityManagerInterface $entityManager): Response
    {
        $this->getUser()->removeActivity($activity);
        $entityManager->flush();

        return new Response(Response::HTTP_NO_CONTENT);
    }
}
