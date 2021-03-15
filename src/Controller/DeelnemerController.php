<?php

namespace App\Controller;

use App\Entity\Activity;
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
        $user = $this->getUser();

        $beschikbareActiviteiten = $this->getDoctrine()
            ->getRepository(Activity::class)
            ->getBeschikbareActiviteiten($user->getId());

        $ingeschrevenActiviteiten = $this->getDoctrine()
            ->getRepository(Activity::class)
            ->getIngeschrevenActiviteiten($user->getId());

        $totaal = $this->getDoctrine()
            ->getRepository(Activity::class)
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
            ->getRepository(Activity::class)
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
            ->getRepository(Activity::class)
            ->find($id);
        $user = $this->getUser();
        $user->removeActiviteit($activiteit);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('activiteiten');
    }

}
