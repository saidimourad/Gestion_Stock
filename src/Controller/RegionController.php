<?php

namespace App\Controller;

use App\Entity\Region;
use App\Form\RegionType;
use App\Repository\RegionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Service\decodeID;



class RegionController extends AbstractController
{
        /**
         * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR') ")
     * @Route("/region/{action}/{id}", name="region")
     */
    public function index(Request $request, $action=0, $id=0,decodeID $decodeID )
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(Region::class);
        $region = new Region();
        if ((base64_decode($action)) > 0)
        {
            $region = $rep->findOneBy(['id' => (base64_decode($id)/$decodeID->getDecode())]);
            if(base64_decode($action)> 1)
            {

                if ($this->isCsrfTokenValid('delete'.$region->getId(), $request->request->get('_token'))) {

                    $em->remove($region);
                    $em->flush();
                    $this->addFlash('success', "Suppression avec succès");

                    return $this->redirectToRoute('region');
                }
            }
        }
        $listReg = $rep->findAll();


        $form = $this->createForm(RegionType::class,$region);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($region);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('region');
        }

        return $this->render('region/index.html.twig', [
            'regions' => $listReg, 'form' =>$form->createView()
        ]);
    }


}
