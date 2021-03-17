<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\ActivityFormType;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/admin/activiteiten", name="activiteitenoverzicht")
     */
    public function activityOverview(ActivityRepository $activityRepository): Response
    {
        return $this->render('medewerker/activiteiten.html.twig', [
            'activiteiten' => $activityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/details/{id}", name="details")
     */
    public function details(
        Activity $activity,
        ActivityRepository $activityRepository,
    ): Response {
        return $this->render('medewerker/details.html.twig', [
            'activiteit' => $activity,
            'deelnemers' => $activity->getUsers(),
            'aantal' => $activityRepository->getTotalActivities()
        ]);
    }

    /**
     * @Route("/admin/beheer", name="beheer")
     */
    public function admin(ActivityRepository $activityRepository): Response
    {
        return $this->render('medewerker/beheer.html.twig', [
            'activiteiten' => $activityRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin/add", name="add")
     */
    public function add(
        Request $request,
        EntityManagerInterface $entityManager,
        ActivityRepository $activityRepository
    ): Response {
        $activity = new Activity();

        $form = $this->createForm(ActivityFormType::class, $activity);
        $form->add('save', SubmitType::class, ['label' => 'voeg toe']);
        //$form->add('reset', ResetType::class, array('label'=>"reset"));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($activity);
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'activiteit toegevoegd!'
            );
            return $this->redirectToRoute('beheer');
        }

        return $this->render('medewerker/add.html.twig', [
            'form' => $form->createView(),
            'naam' => 'toevoegen',
            'aantal' => $activityRepository->getTotalActivities(),
        ]);
    }

    /**
     * @Route("/admin/update/{id}", name="update")
     */
    public function update(
        Activity $activity,
        Request $request,
        EntityManagerInterface $entityManager,
        ActivityRepository $activityRepository
    ): Response {
        $form = $this->createForm(ActivityFormType::class, $activity);
        $form->add('save', SubmitType::class, ['label' => 'aanpassen']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'activiteit aangepast!'
            );

            return $this->redirectToRoute('beheer');
        }

        return $this->render('medewerker/add.html.twig', [
            'form' => $form->createView(),
            'naam' => 'aanpassen',
            'aantal' => $activityRepository->getTotalActivities(),
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="delete")
     */
    public function delete(Activity $activity, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($activity);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'activiteit verwijderd!'
        );

        return $this->redirectToRoute('beheer');
    }
}
