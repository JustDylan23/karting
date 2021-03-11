<?php

namespace App\Controller;

use App\Entity\Activiteit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeelnemerController extends AbstractController
{
    /**
     * @Route("/user/activiteiten", name="activiteiten")
     */
    public function activiteitenAction(): Response
    {
        $usr = $this->get('security.token_storage')->getToken()->getUser();

        $beschikbareActiviteiten = $this->getDoctrine()
            ->getRepository(Activiteit::class)
            ->getBeschikbareActiviteiten($usr->getId());

        $ingeschrevenActiviteiten = $this->getDoctrine()
            ->getRepository(Activiteit::class)
            ->getIngeschrevenActiviteiten($usr->getId());

        $totaal = $this->getDoctrine()
            ->getRepository(Activiteit::class)
            ->getTotaal($ingeschrevenActiviteiten);


        return $this->render('deelnemer/activiteiten.html.twig', [
            'beschikbare_activiteiten' => $beschikbareActiviteiten,
            'ingeschreven_activiteiten' => $ingeschrevenActiviteiten,
            'totaal' => $totaal,
        ]);
    }

    /**
     * @Route("/user/inschrijven/{id}", name="inschrijven")
     */
    public function inschrijvenActiviteitAction($id): Response
    {

        $activiteit = $this->getDoctrine()
            ->getRepository(Activiteit::class)
            ->find($id);
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->addActiviteit($activiteit);

        $em = $this->getDoctrine()->getManager();
        $em->persist($usr);
        $em->flush();

        return $this->redirectToRoute('activiteiten');
    }

    /**
     * @Route("/user/uitschrijven/{id}", name="uitschrijven")
     */
    public function uitschrijvenActiviteitAction($id): Response
    {
        $activiteit = $this->getDoctrine()
            ->getRepository(Activiteit::class)
            ->find($id);
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->removeActiviteit($activiteit);
        $em = $this->getDoctrine()->getManager();
        $em->persist($usr);
        $em->flush();
        return $this->redirectToRoute('activiteiten');
    }

}
