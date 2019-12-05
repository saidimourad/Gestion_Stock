<?php

namespace App\Controller;

use App\Entity\AffecterChefbureau;
use App\Form\AffecterChefbureauType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Service\decodeID;


class AffecterchbController extends AbstractController
{

    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR')")
     * @Route("/affecterchb/{action}/{id}", name="affecterchb")
     *
     */

    public function index(Request $request, $action=0, $id=0,decodeID $decodeID )
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(AffecterChefbureau::class);
        $chbureau= new AffecterChefbureau();
        if ((base64_decode($action)) > 0)
        {
            $chbureau = $rep->findOneBy(['id' => (base64_decode($id)/$decodeID->getDecode())]);
            if(base64_decode($action) > 1)
            {
                if ($this->isCsrfTokenValid('delete'.$chbureau->getId(), $request->request->get('_token'))) {

                    $em->remove($chbureau);
                    $em->flush();
                    $this->addFlash('success', "Suppression avec succès");

                    return $this->redirectToRoute('affecterchb');
                }
            }
        }
        $list = $rep->findAllannee();


        $form = $this->createForm(AffecterChefbureauType::class,$chbureau);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $chbureau->setDate(new \DateTime());
            $em->persist($chbureau);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('affecterchb');
        }

        return $this->render('affecterchb/index.html.twig', [
            'affchefbureau' => $list, 'form' =>$form->createView()
        ]);
    }

}
