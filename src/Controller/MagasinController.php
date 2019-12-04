<?php

namespace App\Controller;

use App\Entity\Magasin;
use App\Form\MagasinType;
use App\Repository\MagasinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Service\decodeID;



class MagasinController extends AbstractController
{


    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR') ")
     * @Route("/magasin/{action}/{id}", name="magasin")
     */
    public function index(Request $request, $action=0, $id=0 ,decodeID $decodeID)
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(Magasin::class);
        $magasin = new Magasin();
        if ((base64_decode($action)) > 0)
        { $magasin = $rep->findOneBy(['id' => (base64_decode($id)/$decodeID->getDecode())]);
            if(base64_decode($action) > 1)
            {
                if ($this->isCsrfTokenValid('delete'.$magasin->getId(), $request->request->get('_token')))
                {
                    $em->remove($magasin);
                    $em->flush();
                    $this->addFlash('success', "Suppression avec succès");

                    return $this->redirectToRoute('magasin');
                }
            }
        }
        $listMag = $rep->findAll();


        $form = $this->createForm(MagasinType::class,$magasin);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($magasin);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('magasin');
        }

        return $this->render('magasin/index.html.twig', [
            'magasins' => $listMag, 'form' =>$form->createView()
        ]);
    }



}
