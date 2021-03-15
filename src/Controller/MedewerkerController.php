<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\User;
use App\Form\ActivityFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedewerkerController extends AbstractController
{
    /**
     * @Route("/admin/activiteiten", name="activiteitenoverzicht")
     */
    public function activiteitenOverzichtAction(): Response
    {

        $activiteiten = $this->getDoctrine()
            ->getRepository(Activity::class)
            ->findAll();

        return $this->render('medewerker/activiteiten.html.twig', [
            'activiteiten' => $activiteiten
        ]);
    }

    /**
     * @Route("/admin/details/{id}", name="details")
     */
    public function detailsAction($id): Response
    {
        $activiteiten = $this->getDoctrine()
            ->getRepository(Activity::class)
            ->findAll();
        $activiteit = $this->getDoctrine()
            ->getRepository(Activity::class)
            ->find($id);

        $deelnemers = $this->getDoctrine()
            ->getRepository(User::class)
            ->getDeelnemers($id);


        return $this->render('medewerker/details.html.twig', [
            'activiteit' => $activiteit,
            'deelnemers' => $deelnemers,
            'aantal' => count($activiteiten)
        ]);
    }

    /**
     * @Route("/admin/beheer", name="beheer")
     */
    public function beheerAction(): Response
    {
        $activiteiten = $this->getDoctrine()
            ->getRepository(Activity::class)
            ->findAll();

        return $this->render('medewerker/beheer.html.twig', [
            'activiteiten' => $activiteiten
        ]);
    }

    /**
     * @Route("/admin/add", name="add")
     */
    public function addAction(Request $request): Response
    {
        // create a user and a contact
        $a = new Activity();

        $form = $this->createForm(ActivityFormType::class, $a);
        $form->add('save', SubmitType::class, ['label' => 'voeg toe']);
        //$form->add('reset', ResetType::class, array('label'=>"reset"));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($a);
            $em->flush();

            $this->addFlash(
                'notice',
                'activiteit toegevoegd!'
            );
            return $this->redirectToRoute('beheer');
        }
        $activiteiten = $this->getDoctrine()
            ->getRepository(Activity::class)
            ->findAll();
        return $this->render('medewerker/add.html.twig', ['form' => $form->createView(), 'naam' => 'toevoegen', 'aantal' => count($activiteiten)
        ]);
    }

    /**
     * @Route("/admin/update/{id}", name="update")
     */
    public function updateAction($id, Request $request): Response
    {
        $a = $this->getDoctrine()
            ->getRepository(Activity::class)
            ->find($id);

        $form = $this->createForm(ActivityFormType::class, $a);
        $form->add('save', SubmitType::class, ['label' => 'aanpassen']);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the contact (no queries yet)
            $em->persist($a);


            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
            $this->addFlash(
                'notice',
                'activiteit aangepast!'
            );
            return $this->redirectToRoute('beheer');
        }

        $activiteiten = $this->getDoctrine()
            ->getRepository(Activity::class)
            ->findAll();

        return $this->render('medewerker/add.html.twig', ['form' => $form->createView(), 'naam' => 'aanpassen', 'aantal' => count($activiteiten)]);
    }

    /**
     * @Route("/admin/delete/{id}", name="delete")
     */
    public function deleteAction($id): Response
    {
        $em = $this->getDoctrine()->getManager();
        $a = $this->getDoctrine()
                  ->getRepository(Activity::class)->find($id);
        $em->remove($a);
        $em->flush();

        $this->addFlash(
            'notice',
            'activiteit verwijderd!'
        );
        return $this->redirectToRoute('beheer');

    }
}
