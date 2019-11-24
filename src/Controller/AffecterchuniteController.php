<?php

namespace App\Controller;

use App\Entity\AffecterChefunite;
use App\Form\AffecterChefuniteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AffecterchuniteController extends AbstractController
{




    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     * @Route("/affecterchunite/{action}/{id}", name="affecterchunite")
     */

    public function index(Request $request, $action=0, $id=0 )
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(AffecterChefunite::class);
        $chunite = new AffecterChefunite();
        if ((base64_decode($action)) > 0)
        {
            $chunite = $rep->findOneBy(['id' =>  (base64_decode($id)-111985)]);
            if(base64_decode($action) > 1)
            {
                if ($this->isCsrfTokenValid('delete'.$chunite->getId(), $request->request->get('_token'))) {

                    $em->remove($chunite);
                    $em->flush();
                    $this->addFlash('success', "Suppression avec succès");

                    return $this->redirectToRoute('affecterchb');
                }
            }
        }
        $list = $rep->findAllannee();


        $form = $this->createForm(AffecterChefuniteType::class,$chunite);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $chunite->setDate(new \DateTime());
            $em->persist($chunite);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('affecterchunite');
        }

        return $this->render('affecterchunite/index.html.twig', [
            'affecterchu' => $list, 'form' =>$form->createView()
        ]);
    }


}
