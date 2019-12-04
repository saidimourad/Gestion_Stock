<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Magasin;
use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\DetailsortieRepository;
use App\Repository\MagasinRepository;
use App\Repository\SortieRepository;
use App\Service\decodeID;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Detailsortie;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;


use Dompdf\Dompdf;
use Dompdf\Options;

class SortieController extends AbstractController
{


    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     * @Route("/sortie", name="sortie")
     */
    public function index(SortieRepository $sortieRepository)
    {
        $roles = $this->getUser()->getRoles();
        if ($roles['0'] == 'ROLE_MAGASINIER') {

            $rs = $sortieRepository->findMagasinEncours($this->getUser()->getId());
            if (!$rs) {
                //    echo "le tableau est vide.";
                $message = "Vérifier si vous êtes affecter";
                return $this->render('security/500.html.twig', array(
                    'message' => $message
                ));

            } else {

                $sorties = $sortieRepository->listesortie($this->getUser()->getId());
            }
        } elseif ($roles['0'] == 'ROLE_ADMIN' or $roles['0'] == 'ROLE_DIRECTEUR') {
            $sorties = $this->getDoctrine()->getRepository(Sortie::class)->findAll();

        }

        return $this->render('sortie/index.html.twig', array('sorties' => $sorties));
    }

    /**
     * @Security("is_granted('ROLE_MAGASINIER')")
     * @Route("sortie/newsortie", name="newsortie")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexActionNew(Request $request)
    {

        $form = $this->createForm(SortieType::class);
        return $this->render('sortie/new.html.twig', [
            'form' => $form->createView()
        ]);

    }

/*
    /**
     * @Security("is_granted('ROLE_MAGASINIER')")
     * @Route("addsorties", name="addsorties")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
   /* public function indexActioncreates(Request $request, SortieRepository $sortieRepository, MagasinRepository $magasinRepository)
    {

        $form = $this->createForm(SortieType::class);
        $rs = $sortieRepository->findMagasinEncours($this->getUser()->getId());
        if (!$rs) {
            //    echo "le tableau est vide.";
            $message = "Vérifier si vous êtes affecter";
            return $this->render('security/500.html.twig', array(
                'message' => $message
            ));

            //throw $this->createNotFoundException('Verifier si vous etes affecter.');
        } else {

            foreach ($rs as $key => $value) {
                $id = $value['id'];
            }
            $magasin = $this->getDoctrine()->getRepository(Magasin::class)->findOneBy(['id' => $id]);
        }
        //  echo  $id;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $val=false;
            $sortie = $form->getData();
            $detail = $sortie->getDetailsorties();
            foreach ($detail as $key => $value) {
                $test = $sortieRepository->testsortie($this->getUser()->getId(), $value->getArticle());
                $qtes = $value->getQtesortie();
                foreach ($test as $key => $value) {
                    $nomart = $value['nom_art'];
                    $vstock = $value['entree'] - $value['sortie'];
                    if (($vstock - $qtes) < $value['qte_min'] and ($vstock - $qtes) > 0) {
                        $vsolde = $vstock - $qtes;
                        $message = " Stock sera épuisé de l'article: " . $nomart . " quantité en stock :" . $vsolde;
                        $this->addFlash('info', "$message");
                        $val = true;
                    } elseif (($vstock < $qtes)) {
                        $message = " Stock indisponible de l'article: " . $nomart . " quantité en stock :" . $vstock;
                        // echo '<script> alert("'.$message.'")</script>';
                        $this->addFlash('danger', "$message");
                        $val = false;
                    }
                }
            }

            if ($val == true) {
                $em = $this->getDoctrine()->getManager();
                $sortie->setUser($this->getUser());
                $sortie->setMagasin($magasin);
                $sortie->setRefSortie($sortieRepository->maxid() + 1);
                $sortie->setDateSortie(new \DateTime());
                $em->persist($sortie);
                $em->flush();
                $this->addFlash('success', "Opération d'ajout avec succées");
                return $this->redirect($this->generateUrl('showsortie', array('id' => $sortie->getId())));
            }
        }
        return $this->render('sortie/new.html.twig', ['form' => $form->createView()]);
    }*/

    /**
     *  @Security("is_granted('ROLE_MAGASINIER')")
     * @Route("addsortie", name="addsortie")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexActioncreatess(Request $request, SortieRepository $sortieRepository, MagasinRepository $magasinRepository,decodeID $decodeID)
    {
        $form = $this->createForm(SortieType::class);
        $rs = $sortieRepository->findMagasinEncours($this->getUser()->getId());
        if (!$rs) {
            //    echo "le tableau est vide.";
            $message = "Vérifier si vous  êtes affecter";
            return $this->render('security/500.html.twig', array(
                'message' => $message
            ));
            //throw $this->createNotFoundException('Verifier si vous etes affecter.');
        } else {

            foreach ($rs as $key => $value) {
                $id = $value['id'];
            }
            $magasin = $this->getDoctrine()->getRepository(Magasin::class)->findOneBy(['id' => $id]);
        }
        //  echo  $id;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $val = true;
            $sortie = $form->getData();
            $detail = $sortie->getDetailsorties();
            foreach ($detail as $key => $value) {
                $test = $sortieRepository->testsortie($this->getUser()->getId(), $value->getArticle());
                $qtes = $value->getQtesortie();
                foreach ($test as $key => $value) {
                    $nomart = $value['nom_art'];
                    $vstock = $value['entree'] - $value['sortie'];
                    if (($vstock - $qtes) < $value['qte_min'] and ($vstock - $qtes) > 0) {
                        $vsolde = $vstock - $qtes;
                        $message = " Stock sera épuisé de l'article: " . $nomart . " quantité en stock :" . $vsolde;
                        $this->addFlash('info', "$message");
                        $val = true;
                    } elseif (($vstock < $qtes)) {
                        $message = " Stock indisponible de l'article: " . $nomart . " quantité en stock :" . $vstock;
                        // echo '<script> alert("'.$message.'")</script>';
                        $this->addFlash('danger', "$message");
                        $val = false;
                    }
                }
                if ($val == true) {
                    $em = $this->getDoctrine()->getManager();
                    $sortie->setUser($this->getUser());
                    $sortie->setMagasin($magasin);
                    $sortie->setRefSortie($sortieRepository->maxid() + 1);
                    $sortie->setDateSortie(new \DateTime());
                    $em->persist($sortie);
                    $em->flush();
                    $this->addFlash('success', "Opération d'ajout avec succées");
                    return $this->redirect($this->generateUrl('showsortie', array('id' => (base64_encode($sortie->getId()*$decodeID->getDecode())))));
                }
            }
        }
        return $this->render('sortie/new.html.twig', ['form' => $form->createView()]);
    }



    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     * @Route("sortie/show/{id}", name="showsortie")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function showAction($id, DetailsortieRepository $detailRepository, SortieRepository $sortieRepository,decodeID $decodeID)
    {
        $roles=$this->getUser()->getRoles();
        $em = $this->getDoctrine()->getManager();
        if($roles['0']=='ROLE_MAGASINIER') {
            $rs = $sortieRepository->findMagasinEncours($this->getUser()->getId());
            if (!$rs) {
                //    echo "le tableau est vide.";
                $message = "Vérifier si vous  êtes affecter";
                return $this->render('security/500.html.twig', array(
                    'message' => $message

                ));

            } else {

                $entity = $em->getRepository(Sortie::class)->find(base64_decode($id)/$decodeID->getDecode());
                $ar_sorties = $detailRepository->search(base64_decode($id)/$decodeID->getDecode());

                if (!$entity) {

                    $message = "Détail n'\existe pas";
                    return $this->render('security/500.html.twig', array(
                        'message' => $message));

                }


                return $this->render('sortie/show.html.twig', array(
                    'entity' => $entity,
                    'sorties' => $ar_sorties,
                    // 'somme' => $somme
                    /* 'delete_form' => $deleteForm->createView(),*/
                ));
            }
        }
        elseif ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR') {


            $entity = $em->getRepository(Sortie::class)->find(base64_decode($id)/$decodeID->getDecode());
            $ar_sorties = $detailRepository->search(base64_decode($id)/$decodeID->getDecode());
            return $this->render('sortie/show.html.twig', array(
                'entity' => $entity,
                'sorties' => $ar_sorties,

            ));

        }
    }

    /**
     * @Security("is_granted('ROLE_MAGASINIER')")
     * @Route("sortie/updatesortie/{id}", name="updatesortie")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $id, SortieRepository $sortieRepository,decodeID $decodeID)
    {

        $rs = $sortieRepository->findMagasinEncours($this->getUser()->getId());
        if (!$rs) {
            //    echo "le tableau est vide.";
            $message = "Vérifier si vous  êtes affecter";
            return $this->render('security/500.html.twig', array(
                'message' => $message

            ));

        } else {

            $em = $this->getDoctrine()->getManager();
            /**
             * @var $entree Sortie
             *
             */

            $sortie = $em->getRepository(Sortie::class)->findOneBy(['id' => (base64_decode($id)/$decodeID->getDecode())]);

            //   $user->setFullname('OverSeas media');
            // save the records that are in the database first to compare them with the new one the user sent
            // make sure this line comes before the $form->handleRequest();
            $orignalDetails = new ArrayCollection();
            foreach ($sortie->getDetailsorties() as $detail) {
                $orignalDetails->add($detail);
            }
            $form = $this->createForm(SortieType::class, $sortie);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                // get rid of the ones that the user got rid of in the interface (DOM)
                foreach ($orignalDetails as $detail) {
                    // check if the exp is in the $user->getExp()
//                dump($user->getExp()->contains($exp));
                    if ($sortie->getDetailsorties()->contains($detail) === false) {
                        $em->remove($detail);
                    }
                }

                ///////////////
                ///
                ///

             /*   $sortie = $form->getData();
                $detail = $sortie->getDetailsorties();

                foreach ($detail as $key => $value) {
                    $test = $sortieRepository->testsortie($this->getUser()->getId(), $value->getArticle());
                    $qtes = $value->getQtesortie();

                    foreach ($test as $key => $value) {

                        $nomart = $value['nom_art'];
                        $vstock = $value['entree'] - $value['sortie'];

                        if (($vstock - $qtes) < $value['qte_min'] and ($vstock - $qtes) > 0) {
                            $vsolde = $vstock - $qtes;
                            $message = " Stock sera epuisé de l'article: " . $nomart . " quantité en stock :" . $vsolde;
                            $this->addFlash('info', "$message");
                            $val = true;

                        } elseif (($vstock < $qtes)) {

                            $message = " Stock indisponible de l'article: " . $nomart . " quantité en stock :" . $vstock;
                            $this->addFlash('danger', "$message");
                            $val = false;
                        }

                    }

                }

                if ($val == true) {*/


                    $em->persist($sortie);
                    $em->flush();
                    $this->addFlash('success', "Opération de mise à jours avec succées");
                    return $this->redirect($this->generateUrl('showsortie', array('id' => (base64_encode($sortie->getId()*$decodeID->getDecode())))));
                //}
            }

            // replace this example code with whatever you need

            return $this->render('sortie/update.html.twig', [
                'form' => $form->createView(),'sortie'=>$sortie
            ]);

        }


    }



    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     * @Route("sortie/imprimersortie/{id}", name="imprimersortie")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function ImpAction($id,  DetailsortieRepository $detailRepository, SortieRepository $sortieRepository,decodeID $decodeID)
    {

        $id=(base64_decode($id)/$decodeID->getDecode());

        $roles=$this->getUser()->getRoles();
        $em = $this->getDoctrine()->getManager();
        if($roles['0']=='ROLE_MAGASINIER') {
            $rs = $sortieRepository->findMagasinEncours($this->getUser()->getId());
            if (!$rs) {
                //    echo "le tableau est vide.";
                $message = "Verifier si vous  êtes affecter";
                return $this->render('security/500.html.twig', array(
                    'message' => $message

                ));

            } else {



                $entity = $em->getRepository(Sortie::class)->find(($id));
                $ar_sorties = $detailRepository->search(($id));



                if (!$entity) {

                    $message = "Détail n existe pas";
                    return $this->render('security/500.html.twig', array(
                        'message' => $message));

                }


            }
        }
        elseif ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR') {


            $entity = $em->getRepository(Sortie::class)->find(($id));
            $ar_sorties = $detailRepository->search(($id));

        }




            /* $deleteForm = $this->createDeleteForm($id);*/



            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');

            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);

            // Retrieve the HTML generated in our twig file
            $html =  $this->render('sortie/imprimer.html.twig', array(
                'entity' => $entity,
                'sorties' => $ar_sorties,
               // 'somme' => $somme
                /* 'delete_form' => $deleteForm->createView(),*/
            ));

            /*  $html = $this->renderView('default/mypdf.html.twig', [
                  'title' => "Welcome to our PDF Test"
              ]);*/

            // Load HTML to Dompdf
            $dompdf->loadHtml($html);

            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser (force download)
            $dompdf->stream("benentree.pdf", [
                "Attachment" => false
            ]);



        }

    //}



    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     * @Route("/sortie_delete/{id}", name="sortie_delete" , methods="DELETE|POST")
     */
    public function supprimer(Request $request, $id,decodeID $decodeID )
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(Sortie::class);
        $entity = $rep->findOneBy(['id' => (base64_decode($id)/$decodeID->getDecode())]);
        if (!$entity) {
            throw $this->createNotFoundException('Enregistrement introuvable');
            return new Response('not valid');
        } else {
            if ($this->isCsrfTokenValid('delete'.$entity->getId(), $request->request->get('_token'))) {

                $em->remove($entity);
                $em->flush();
                return $this->redirectToRoute('sortie');
            }
        }

    }

    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     * @Route("sortie/sortie_verifier", name="sortie_verifier" , methods="DELETE|POST")
     *
     * @return Response
     */

    public function verifierStock(Request $request, SortieRepository $sortieRepository, MagasinRepository $magasinRepository): Response
    {
        if ($request->isXmlHttpRequest()) {
            $form = $this->createForm(SortieType::class);
            $rs = $sortieRepository->findMagasinEncours($this->getUser()->getId());
            if (!$rs) {
                //    echo "le tableau est vide.";
                $message = "Vérifier si vous  êtes affecter";
              //  return $this->render('security/500.html.twig', array(
                    //'message' => $message
               // ));

                //throw $this->createNotFoundException('Verifier si vous etes affecter.');
            } else {

                foreach ($rs as $key => $value) {
                    $id = $value['id'];
                }
                $magasin = $this->getDoctrine()->getRepository(Magasin::class)->findOneBy(['id' => $id]);
            }
            //  echo  $id;
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // $val=false;
                $sortie = $form->getData();
                $detail = $sortie->getDetailsorties();
                foreach ($detail as $key => $value) {
                    $test = $sortieRepository->testsortie($this->getUser()->getId(), $value->getArticle());
                    $qtes = $value->getQtesortie();
                    foreach ($test as $key => $value) {
                        $nomart = $value['nom_art'];
                        $vstock = $value['entree'] - $value['sortie'];
                        if (($vstock - $qtes) < $value['qte_min'] and ($vstock - $qtes) > 0) {
                            $vsolde = $vstock - $qtes;

                          //  echo "<span class='status-not-available'> UStock sera epuisé.</span>";

                            $message = " Stock sera epuisé de l'article: " . $nomart . " quantité en stock :" . $vsolde;

                            return new Response(json_encode($message));
                          //  $this->addFlash('info', "$message");
                            // $val = true;
                        } elseif (($vstock < $qtes)) {
                            $message = " Stock indisponible de l'article: " . $nomart . " quantité en stock :" . $vstock;
                            // echo '<script> alert("'.$message.'")</script>';
                            return new Response(json_encode($message));

                           // echo "<span class='status-not-available'> Stock indisponible de l'article</span>";

                            //$this->addFlash('danger', "$message");
                            //  $val = false;
                        }
                    }
                }

            }
        }

        return new  JsonResponse(['type' => 'error',
            'message' => 'This is only accesible in AJAX'
        ], 500);
    }


    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     * @Route("sortie/ajaxGetProductsAction", name="ajaxGetProductsAction" , methods="GET|POST")
     *
     * @return Response
     */


    public function searchAction(Request $request, SortieRepository $sortieRepository)
    {

        $qtes = floatval($request->get('q'));


        $article = $request->get('a');
        // foreach ($detail as $key => $value) {
        $posts = $sortieRepository->testsortie($this->getUser()->getId(), $article);
        // $qtes = $value->getQtesortie();

        if (!$posts) {
            $message['posts']['error'] = "Post Not found ";
        } else {
            foreach ($posts as $key => $value) {
                $nomart = $value['nom_art'];
                $vstock = $value['entree'] - $value['sortie'];
                if (($vstock - $qtes) < $value['qte_min'] and ($vstock - $qtes) > 0) {
                    $vsolde = $vstock - $qtes;
                    //$message = " Stock sera epuisé de l'article: " . $nomart . " quantité en stock :" . $vsolde;
                    $message['posts']['repture']="Stock sera epuisé de l'article: " . $nomart . " quantité en stock :" . $vsolde;
                    return new Response(json_encode($message));
                    //  $message = " Stock sera epuisé de l'article: " . $nomart . " quantité en stock :" . $vsolde;
                    //  $this->addFlash('info', "$message");
                    // $val = true;
                } elseif (($vstock < $qtes)) {
                   // $message = " Stock indisponible de l'article: " . $nomart . " quantité en stock :" . $vstock;

                    $message['posts']['indisponible'] = " Stock indisponible de l'article: " . $nomart . " quantité en stock :" . $vstock;
                    // echo '<script> alert("'.$message.'")</script>';
                    return new Response(json_encode($message));
                    //  $message = " Stock indisponible de l'article: " . $nomart . " quantité en stock :" . $vstock;
                    // echo '<script> alert("'.$message.'")</script>';
                    //  $this->addFlash('danger', "$message");
                    //  $val = false;
                }
                else
                {
                    $message['posts']['disponible'] = " Stock disponible de l'article: " . $nomart . " quantité en stock :" . $vstock;
                    // echo '<script> alert("'.$message.'")</script>';
                    return new Response(json_encode($message));
                }
            }
        }
        return new Response(json_encode($message));
    }





}
