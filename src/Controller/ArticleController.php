<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\CategorieType;
use App\Service\decodeID;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\AffecterChefuniteRepository;



class ArticleController extends AbstractController
{

    /**
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_DIRECTEUR') or has_role('ROLE_CHEFUNITE')")
     * @Route("/article/{action}/{id}", name="article", methods="DELETE|GET|POST")
     */
    public function indexAction(Request $request, $action=0, $id=0,AffecterChefuniteRepository $affchu,decodeID $decodeID )
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
        $rep = $this->getDoctrine()->getRepository(Article::class);
        $article = new Article();


        if ((base64_decode($action)) > 0)
        {
            // $article  = $rep->findOneBy(['id' => ($decodeID->decodeID($id))]);
            $article  = $rep->findOneBy(['id' => (base64_decode($id)/$decodeID->getDecode())]);
           // if (($decodeID->decodeID($action)) > 1)
            if(base64_decode($action) > 1)

            {
                if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {

                    $em->remove($article);
                   $em->flush();
                      $this->addFlash('success', "Suppression avec succès");

                return $this->redirectToRoute('article');
                }
            }
        }
        $listart = $rep->findAll();


        $form = $this->createForm(ArticleType::class,$article );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($article);
            $em->flush();
            $this->addFlash('success', "Opération avec succées");

            return $this->redirectToRoute('article');
        }

        return $this->render('article/index.html.twig', [
            'articles' => $listart, 'form' =>$form->createView()
        ]);
    }


}
