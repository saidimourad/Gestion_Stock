<?php

namespace App\Controller;

use App\Entity\AnneeScolaire;
use App\Form\AnneeScolaireType;
use App\Repository\AnneeScolaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


use Symfony\Component\Routing\Annotation\Route;


class AnneeScolaireController extends AbstractController
{


    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     * @Route("/annee_scolaire/{action}/{id}", name="annee_scolaire")
     */
    public function index(Request $request, $action=0, $id=0 )
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(AnneeScolaire::class);
        $annee = new AnneeScolaire();
        if ((base64_decode($action)) > 0)
        {
            //$annee = $rep->findOneBy(['id' => (base64_decode($id)-111985)]);
            $annee = $rep->findOneBy(['id' => (base64_decode($id)-111985)]);

            if(base64_decode($action) > 1)
            {
                if ($this->isCsrfTokenValid('delete'.$annee->getId(), $request->request->get('_token'))) {

                    $em->remove($annee);
                    $em->flush();
                    $this->addFlash('success', "Suppression avec succès");

                    return $this->redirectToRoute('annee_scolaire');
                }
            }
        }
        $listA = $rep->findAll();


        $form = $this->createForm(AnneeScolaireType::class,$annee);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            //
            //$annee->setEncours(0);
            $em->persist($annee);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('annee_scolaire');
        }

        return $this->render('annee_scolaire/index.html.twig', [
            'annee_scolaires' => $listA, 'form' =>$form->createView()
        ]);
    }


    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     *
     * @Route("/anneescolaire/encours/{id}", name="anneescolaire_encours")
     */
    public function encour($id=0, AnneeScolaireRepository $encoursReposotory)
    {
        $encoursReposotory->rendreencours((base64_decode($id)-111985));


        return $this->redirectToRoute('annee_scolaire');

    }



    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     *
     * @Route("/anneescolaire/activer/{id}", name="activer_anneescolaire")
     */
    public function activer( $id=0, AnneeScolaireRepository $activerReposotory)
    {
        $activerReposotory->activer_annee((base64_decode($id)-111985));


        return $this->redirectToRoute('annee_scolaire');


    }

    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     *
     * @Route("/anneescolaire/desactiver/{id}", name="desactiver_anneescolaire")
     */
    public function desactiver( $id=0, AnneeScolaireRepository $activerReposotory)
    {
        $activerReposotory->deactiver_annee((base64_decode($id)-111985));


        return $this->redirectToRoute('annee_scolaire');


    }


}
