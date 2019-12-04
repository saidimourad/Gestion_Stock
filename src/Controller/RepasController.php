<?php

namespace App\Controller;

use App\Entity\Repas;
use App\Form\RepasType;
use App\Repository\RepasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Service\decodeID;


class RepasController extends AbstractController
{


    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR') ")
     * @Route("/repas/{action}/{id}", name="repas")
     *
     */
    public function index(Request $request, $action = 0, $id = 0,decodeID $decodeID)
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(Repas::class);
        $repas = new Repas();
        if ((base64_decode($action)) > 0) {
            $repas = $rep->findOneBy(['id' => (base64_decode($id)/$decodeID->getDecode())]);
            if (base64_decode($action) > 1) {
                if ($this->isCsrfTokenValid('delete' . $repas->getId(), $request->request->get('_token'))) {
                    $em->remove($repas);
                    $em->flush();
                    $this->addFlash('success', "Suppression avec succès");

                    return $this->redirectToRoute('repas');
                }
            }
        }
        $listRep = $rep->findAll();


        $form = $this->createForm(RepasType::class, $repas);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($repas);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");


            /*     $this->addFlash(
                     'notice',
                     'Succées d"insertion !'
                 );*/
            return $this->redirectToRoute('repas');

        }

        return $this->render('repas/index.html.twig', [
            'repas' => $listRep, 'form' => $form->createView()
        ]);
    }
}
