<?php

namespace App\Controller;

use App\Entity\ActivityType;
use App\Form\ActivityFormType;
use App\Repository\ActivityTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitorController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('bezoeker/index.html.twig', [
            'boodschap' => 'Welkom',
        ]);
    }

    /**
     * @Route("/kartactiviteiten", name="kartactiviteiten")
     */
    public function activities(ActivityTypeRepository $activityTypeRepository): Response
    {
        return $this->render('bezoeker/kartactiviteiten.html.twig', [
            'boodschap' => 'Welkom',
            'soortactiviteiten' => $activityTypeRepository->findAll(),
        ]);
    }

    /**
     * FIXME - route seems to be partially implemented???
     *
     * //@Route("/nieuwSoortActiviteit", name="nieuwSoortActiviteit")
     */
    public function nieuweSoortActiviteitToevoegen(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activityType = new ActivityType();
        $activityType->setName('Geef een naam op!');

        $form = $this->createForm(ActivityFormType::class, $activityType);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activityType = $form->getData();
            $entityManager->persist($activityType);
            $entityManager->flush();

            return $this->redirectToRoute('kartactiviteiten');
        }
        return $this->render('admin/nieuwSA.html.twig', [
            'boodschap' => 'Voeg een nieuwe Activity toe',
            'form' => $form->createView(),
        ]);
    }
}
