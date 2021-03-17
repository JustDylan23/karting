<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/user/activiteiten", name="activiteiten")
     */
    public function activities(ActivityRepository $repository): Response
    {
        $user = $this->getUser();

        $availableActivities = $repository->getAvailableActivities($user->getId());
        $registeredActivities = $repository->getRegisteredActivities($user->getId());

        $total = 0;
        /** @var Activity $activity */
        foreach ($registeredActivities as $activity) {
            $total += $activity->getActivityType()->getPrice();
        }

        return $this->render('deelnemer/activiteiten.html.twig', [
            'beschikbare_activiteiten' => $availableActivities,
            'ingeschreven_activiteiten' => $registeredActivities,
            'totaal' => $total,
        ]);
    }

    /**
     * @Route("/user/inschrijven/{id}", name="inschrijven")
     */
    public function createRegistration(Activity $activity, EntityManagerInterface $entityManager): Response
    {

        $this->getUser()->addActivity($activity);
        $entityManager->flush();

        return $this->redirectToRoute('activiteiten');
    }

    /**
     * @Route("/user/uitschrijven/{id}", name="uitschrijven")
     */
    public function removeRegistration(Activity $activity, EntityManagerInterface $entityManager): Response
    {
        $this->getUser()->removeActivity($activity);
        $entityManager->flush();

        return $this->redirectToRoute('activiteiten');
    }
}
