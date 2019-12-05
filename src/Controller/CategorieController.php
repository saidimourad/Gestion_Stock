<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Repository\AffecterChefuniteRepository;
use App\Service\decodeID;


class CategorieController extends AbstractController
{

    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR') or has_role('ROLE_CHEFUNITE')")
     * @Route("/categorie/{action}/{id}", name="categorie", methods="DELETE|GET|POST")
     */
    public function index(Request $request, $action=0, $id=0,AffecterChefuniteRepository $affchu,decodeID $decodeID )
    {
        $roles=$this->getUser()->getRoles();
        if (  $roles['0']=='ROLE_CHEFUNITE') {
            $rs = $affchu->findAffChefU($this->getUser()->getId());
            if (!$rs) {
                $message = "Vérifier si vous êtes affecter à cette année";
                return $this->render('security/500.html.twig', array(
                    'message' => $message));
            }
        }

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(Categorie::class);
        $categorie = new Categorie();
        if ((base64_decode($action)) > 0)
        {
            $categorie = $rep->findOneBy(['id' => (base64_decode($id)/$decodeID->getDecode())]);
            if(base64_decode($action) > 1)
            {
                if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
                    $em->remove($categorie);
                    $em->flush();
                    $this->addFlash('success', "Suppression avec succès");

                    return $this->redirectToRoute('categorie');
                }
            }
        }
        $listCat = $rep->findAll();


        $form = $this->createForm(CategorieType::class,$categorie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($categorie);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('categorie');
        }

        return $this->render('categorie/index.html.twig', [
             'categories' => $listCat, 'form' =>$form->createView()
        ]);
    }
}
