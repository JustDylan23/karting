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
use Symfony\Component\Serializer\SerializerInterface;

class VisitorController extends AbstractController
{
    /**
     * @Route("/{routes}", name="homepage")
     */
    public function index($routes = null): Response
    {
        return $this->render('vue_visitor.html.twig');
    }

    /**
     * @Route("/api/activities")
     */
    public function activitiesApi(
        ActivityTypeRepository $activityTypeRepository,
        SerializerInterface $serializer
    ): Response {
        return $this->json($serializer->normalize($activityTypeRepository->findAll(), null, ['attributes' => [
            'id',
            'name',
            'minAge',
            'duration',
            'price',
            'description',
        ]]));
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
