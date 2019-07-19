<?php

namespace App\Controller;

use App\Entity\Fonction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\FonctionType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;


class FonctionController extends AbstractController
{
    /**
     * @Route("/fonction", name="fonction")
     */
    public function index()
    {
        $fonctions=$this->getDoctrine()->getRepository(Fonction::class)->findAll();
        return $this->render('fonction/index.html.twig', array('fonctions' => $fonctions ));

    }


    /**
     * @Route("/fonction/new", name="new_fonction")
     * @Route("/fonction/edit/{id}", name="edit_fonction")
     */

    public function form(Fonction $fonction=null, Request $request, ObjectManager $entityManager)
    {
        if(!$fonction)
        {
            $fonction=new Fonction();

        }


        $form = $this->createForm(FonctionType::class,$fonction);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($fonction);
            $entityManager->flush();

            return $this->redirectToRoute('fonction');
        }
        return $this->render('fonction/new.html.twig', ['form'=>$form->createView()]);

    }

}
