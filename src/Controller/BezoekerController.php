<?php

namespace App\Controller;

use App\Entity\ActivityType;
use App\Form\ActivityFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BezoekerController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(): Response
    {
        return $this->render('bezoeker/index.html.twig', ['boodschap' => 'Welkom']);
    }

    /**
     * @Route("/kartactiviteiten", name="kartactiviteiten")
     */
    public function kartactiviteitenAction(): Response
    {
        $repository = $this->getDoctrine()->getRepository(ActivityType::class);
        $soortactiviteiten = $repository->findAll();
        return $this->render('bezoeker/kartactiviteiten.html.twig', ['boodschap' => 'Welkom', 'soortactiviteiten' => $soortactiviteiten]);
    }

    /**
     * @Route("/nieuwSoortActiviteit", name="nieuwSoortActiviteit")
     */
    public function nieuweSoortActiviteitToevoegenAction(Request $request): Response
    {
        $soortAct = new ActivityType();
        $soortAct->setName('Geef een naam op!');

        $form = $this->createForm(ActivityFormType::class, $soortAct);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $soortAct = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($soortAct);
            $em->flush();
            return $this->redirectToRoute('kartactiviteiten');
        }
        return $this->render('admin/nieuwSA.html.twig', ['boodschap' => 'Voeg een nieuwe Activity toe', 'form' => $form->createView(),]);
    }
}
