<?php

namespace App\Controller;

use App\Entity\AffecterMagasinier;
use App\Form\AffecterMagasinierType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Repository\AffecterChefuniteRepository;



class AffecterMagasinierController extends AbstractController
{


    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR') or has_role('ROLE_CHEFUNITE')")
     * @Route("/magasinier/{action}/{id}", name="affectermagasinier")
     */

    public function index(Request $request, $action=0, $id=0,AffecterChefuniteRepository $affchu )
    {

      /*  $roles=$this->getUser()->getRoles();
        if (  $roles['0']=='ROLE_CHEFUNITE') {
            $rs = $affchu->findAffChefU($this->getUser()->getId());
            if (!$rs) {
                $message = "Vérifier si vous êtes affecter à cette année";
                return $this->render('security/500.html.twig', array(
                    'message' => $message));
            }
        }*/

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(AffecterMagasinier::class);
        $magasin = new AffecterMagasinier();
        if ((base64_decode($action)) > 0)
        { $magasin = $rep->findOneBy(['id' => (base64_decode($id)-111985)]);
            if(base64_decode($action) > 1)
            {
                if ($this->isCsrfTokenValid('delete'.$magasin->getId(), $request->request->get('_token'))) {

                    $em->remove($magasin);
                    $em->flush();
                    $this->addFlash('success', "Suppression avec succès");

                    return $this->redirectToRoute('affectermagasinier');
                }
            }
        }
        $listMag = $rep->findAllannee();


        $form = $this->createForm(AffecterMagasinierType::class,$magasin);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $magasin->setDate(new \DateTime());
            $em->persist($magasin);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('affectermagasinier');
        }

        return $this->render('affecter_magasinier/index.html.twig', [
            'affmagasinier' => $listMag, 'form' =>$form->createView()
        ]);
    }



}





