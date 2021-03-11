<?php

namespace App\Controller;

use App\Entity\Soortactiviteit;
use App\Entity\User;
use App\Form\ActiviteitType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
        $repository = $this->getDoctrine()->getRepository(Soortactiviteit::class);
        $soortactiviteiten = $repository->findAll();
        return $this->render('bezoeker/kartactiviteiten.html.twig', ['boodschap' => 'Welkom', 'soortactiviteiten' => $soortactiviteiten]);
    }

    /**
     * @Route("/registreren", name="registreren"): Response
     */
    public function registreren(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->add('save', SubmitType::class, ['label' => "registreren"]);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // 2.5) Is the user new, gebruikersnaam moet uniek zijn
            $repository = $this->getDoctrine()->getRepository(User::class);
            $bestaande_user = $repository->findOneBy(['username' => $form->getData()->getUsername()]);

            if ($bestaande_user == null) {
                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setRoles(['ROLE_USER']);
                // 4) save the User!
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'notice',
                    $user->getNaam() . ' is geregistreerd!'
                );

                return $this->redirectToRoute('homepage');
            }

            $this->addFlash(
                'error',
                $user->getUsername() . " bestaat al!"
            );
            return $this->render('bezoeker/registreren.html.twig', [
                'form' => $form->createView()
            ]);
        }

        return $this->render('bezoeker/registreren.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/nieuwSoortActiviteit", name="nieuwSoortActiviteit")
     */
    public function nieuweSoortActiviteitToevoegenAction(Request $request): Response
    {
        $soortAct = new SoortActiviteit();
        $soortAct->setNaam('Geef een naam op!');

        $form = $this->createForm(ActiviteitType::class, $soortAct);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $soortAct = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($soortAct);
            $em->flush();
            return $this->redirectToRoute('kartactiviteiten');
        }
        return $this->render('admin/nieuwSA.html.twig', ['boodschap' => 'Voeg een nieuwe Activiteit toe', 'form' => $form->createView(),]);
    }
}
