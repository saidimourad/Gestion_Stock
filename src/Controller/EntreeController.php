<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commande;
use App\Entity\Entree;
use App\Entity\Magasin;
use App\Entity\User;
use App\Form\EntreeType;
use App\Entity\Detailentree;
use App\Form\EntreeUpdateType;
use App\Repository\CommandeRepository;
use App\Repository\DetailentreeRepository;
use App\Repository\EntreeRepository;
use App\Repository\MagasinRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use \Datetime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

class EntreeController extends AbstractController
{

    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     * @Route("/entree", name="entree")
     *
     */
    public function index(EntreeRepository $entreeRepository, Request $request, UserService $userservice)
    {
       /// $entrees = $this->getDoctrine()->getRepository(Entree::class)->findAll();

        $roles = $this->getUser()->getRoles();

        if ($roles['0'] == 'ROLE_MAGASINIER') {


          //  $userservice->AffecterMagasiner($this->getUser()->getId());
            $rs = $entreeRepository->findMagasinEncours($this->getUser()->getId());
            if (!$rs) {
                $message = "Vérifier si vous êtes affecter";
                return $this->render('security/500.html.twig', array(
                    'message' => $message));
            } else {


                $entrees = $entreeRepository->listeentree($this->getUser()->getId(), null, null);

            }

        }
        elseif ($roles['0'] == 'ROLE_ADMIN' or $roles['0'] == 'ROLE_DIRECTEUR') {
            $entrees = $this->getDoctrine()->getRepository(Entree::class)->findAll();
            return $this->render('entree/index.html.twig', array('entrees' => $entrees));
        }


       return $this->render('entree/index.html.twig', array('entrees' => $entrees));
    }


    /**
     * @Security("is_granted('ROLE_MAGASINIER')")
     * @Security("has_role('ROLE_MAGASINIER') ")
     * @Route("entree/update/{id}", name="updateentree")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexupdateAction(Request $request, $id, EntreeRepository $entreeRepository)
    {

        $rs = $entreeRepository->findMagasinEncours($this->getUser()->getId());
        if (!$rs) {
            //    echo "le tableau est vide.";
            $message = "Verifier si vous etes affecter";
            return $this->render('security/500.html.twig', array(
                'message' => $message

            ));

        } else {

            $em = $this->getDoctrine()->getManager();
            /**
             * @var $entree Entree
             *
             */

            $entree = $em->getRepository(Entree::class)->findOneBy(['id' => (base64_decode($id)-111985)]);
            $orignalDetails = new ArrayCollection();
            foreach ($entree->getDetailentrees() as $detail) {
                $orignalDetails->add($detail);
            }
            $form = $this->createForm(EntreeUpdateType::class, $entree);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                // get rid of the ones that the user got rid of in the interface (DOM)
                foreach ($orignalDetails as $detail) {

                    if ($entree->getDetailentrees()->contains($detail) === false) {
                        $em->remove($detail);
                    }
                }
                $entree->setDateEntree(new \DateTime());
                $em->persist($entree);
                $em->flush();
                $this->addFlash('success', "Opération de mise à jours avec succées");
                return $this->redirect($this->generateUrl('showentree', array('id' => $id)));
            }


            return $this->render('entree/update.html.twig', [
                'form' => $form->createView(),'entree'=>$entree
            ]);

        }
    }

    /**
     * @Security("is_granted('ROLE_MAGASINIER')")
     * @Security("has_role('ROLE_MAGASINIER') ")
     * @Route("newentree", name="newentree")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexActionNew(Request $request, CommandeRepository $commandeRepository)
    {
        //  $user = $this->getUser();
        //  $userId = $user->getId();
        //  echo $userId;

        $rs = $commandeRepository->selectCommandeByMG($this->getUser()->getId());
        $commande = new Commande();
        $form2 = $this->createFormBuilder($commande)
            ->add('isLivre', ChoiceType::class, array(
                'choices' => array(
                    'Total' => '1',
                    'Partiel' => '2',
                )
            , 'label' => 'Livraison de commande'
            ))
            ->getForm();


        $entree = new Entree();
        $form = $this->createForm(EntreeType::class, $entree);
        return $this->render('entree/new.html.twig', [
            'form' => $form->createView(), 'form2' => $form2->createView(), 'commande' => $rs
        ]);

    }
/**
   * @Security("is_granted('ROLE_MAGASINIER')")
   * @Security("has_role('ROLE_MAGASINIER') ")
    * @Route("addentree", name="addentree")
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\Response
*/
    public function indexActioncreates(Request $request, EntreeRepository $entreeRepository , MagasinRepository $magasinRepository)

    {
        $entree = new Entree();
        $rep = $this->getDoctrine()->getRepository(Commande::class);
        $form1 = $this->createForm(EntreeType::class, $entree);


        $commande = new Commande();
        $form2 = $this->createFormBuilder($commande)
            ->add('isLivre', ChoiceType::class, array(
                'choices' => array(
                    'Total' => '1',
                    'Partiel' => '2',
                )
            , 'label' => 'Livraison de commande'
            ))
            ->getForm();


        $rs = $entreeRepository->findMagasinEncours($this->getUser()->getId());
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

        $form1->handleRequest($request);
        $form2->handleRequest($request);

        if ($form1->isSubmitted() && $form1->isValid()) {
            $entree = $form1->getData();
            $commande = $form2->getData();
            //  dump($commande);
            $idcommande = $entree->getCommande()->getId();
            $commande = $rep->findOneBy(['id' => $idcommande]);
            $commande->setIsLivre(1);
            $commande->setDatelivraison(new \DateTime());;
            $em = $this->getDoctrine()->getManager();
            $entree->setEntuser($this->getUser());
            $entree->setMagasin($magasin);
            $entree->setRefEntree($entreeRepository->maxid() + 1);
            $entree->setDateEntree(new \DateTime());
            //$commande->setDatelivraison(new \DateTime());
            $em->persist($entree);
            $em->flush();
            $em->persist($commande);
            $em->flush();
            $this->addFlash('success', "Opération d'ajout avec succées");

            return $this->redirect($this->generateUrl('showentree', array('id' => (base64_encode($entree->getId()+111985)))));
        }
        return $this->render('entree/new.html.twig', ['form' => $form1->createView()]);


    }
/**
 *
 * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     * @Route("entree/show/{id}", name="showentree")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

public function showAction($id,  DetailentreeRepository $detailRepository, EntreeRepository $entreeRepository)
{
    //$id = (base64_decode($id) - 111985);
    $em = $this->getDoctrine()->getManager();
    $roles = $this->getUser()->getRoles();
    if ($roles['0'] == 'ROLE_MAGASINIER') {

        $rs = $entreeRepository->findMagasinEncours($this->getUser()->getId());
        if (!$rs) {
            //    echo "le tableau est vide.";
            $message = "Verifier si vous etes affecter";
            return $this->render('security/500.html.twig', array(
                'message' => $message));

        } else {

            $entity = $em->getRepository(Entree::class)->find((base64_decode($id) - 111985));
            $ar_entrees = $detailRepository->search((base64_decode($id) - 111985));
            $somme = $detailRepository->sommeEntree((base64_decode($id) - 111985));

            if (!$entity) {

                $message = "Détail n existe pas";
                return $this->render('security/500.html.twig', array(
                    'message' => $message));
            }

            foreach ($somme as $key => $value) {
                $somme = $value;
            }

            return $this->render('entree/show.html.twig', array(
                'entity' => $entity,
                'entrees' => $ar_entrees,
                'somme' => $somme
                /* 'delete_form' => $deleteForm->createView(),*/
            ));
        }
    } elseif ($roles['0'] == 'ROLE_ADMIN' or $roles['0'] == 'ROLE_DIRECTEUR') {

        $entity = $em->getRepository(Entree::class)->find((base64_decode($id) - 111985));
        $ar_entrees = $detailRepository->search((base64_decode($id) - 111985));
        $somme = $detailRepository->sommeEntree((base64_decode($id) - 111985));

        foreach ($somme as $key => $value) {
            $somme = $value;
        }

        return $this->render('entree/show.html.twig', array(
            'entity' => $entity,
            'entrees' => $ar_entrees,
            'somme' => $somme
        ));
    }
}

    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     *
     * @Route("entree/imprimer/{id}", name="imprimerentree")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function ImpAction($id,  DetailentreeRepository $detailRepository, EntreeRepository $entreeRepository)
    {

        $id=(base64_decode($id)-111985);
        $em = $this->getDoctrine()->getManager();
        $roles=$this->getUser()->getRoles();
        if($roles['0']=='ROLE_MAGASINIER') {

            $rs = $entreeRepository->findMagasinEncours($this->getUser()->getId());
            if (!$rs) {
                //    echo "le tableau est vide.";
                $message = "Vérifier si vous êtes affecter";
                return $this->render('security/500.html.twig', array(
                    'message' => $message));

            } else {

                $entity = $em->getRepository(Entree::class)->find($id);
                $ar_entrees = $detailRepository->search($id);
                $somme = $detailRepository->sommeEntree($id);

                if (!$entity) {

                    $message = "Détail n existe pas";
                    return $this->render('security/500.html.twig', array(
                        'message' => $message));
                }

                foreach ($somme as $key => $value) {
                    $somme = $value;
                }
            }
        }
        elseif ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR') {

            $entity = $em->getRepository(Entree::class)->find($id);
            $ar_entrees = $detailRepository->search($id);
            $somme = $detailRepository->sommeEntree($id);

            foreach ($somme as $key => $value) {
                $somme = $value;
            }
        }
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);
            // Retrieve the HTML generated in our twig file
            $html =  $this->render('entree/imprimer.html.twig', array(
                'entity' => $entity,
                'entrees' => $ar_entrees,
                'somme' => $somme
                /* 'delete_form' => $deleteForm->createView(),*/
            ));

          /*  $html = $this->renderView('default/mypdf.html.twig', [
                'title' => "Welcome to our PDF Test"
            ]);*/

            // Load HTML to Dompdf
            $dompdf->loadHtml($html);
            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');
          // $dompdf->SetTitle(md5($id));
            // Render the HTML as PDF
            $dompdf->render();
            // Output the generated PDF to Browser (force download)
            $dompdf->stream("entree.pdf", [
                "Attachment" => false
            ]);

        }

    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     * @Route("/entree_delete/{id}", name="entree_delete", methods="DELETE|POST")
     */
    public function supprimer( Request $request,$id )
    {

        $em = $this->getDoctrine()->getManager();
        $repEntree = $this->getDoctrine()->getRepository(Entree::class);
        $repCommande = $this->getDoctrine()->getRepository(Commande::class);
        $entree = $repEntree->findOneBy(['id' => (base64_decode($id)-111985)]);

        if (!$entree) {
            throw $this->createNotFoundException('Enregistrement introuvable');
            return new Response('not valid');
        } else {
            if ($this->isCsrfTokenValid('delete'.$entree->getId(), $request->request->get('_token'))) {

            $idcommande = $entree->getCommande()->getId();
            $commande = $repCommande->findOneBy(['id' => $idcommande]);
            $commande->setIsLivre(0);
            $commande->setDatelivraison(null);
            $em->persist($commande);
            $em->flush();
            $em->remove($entree);
            $em->flush();
            return $this->redirectToRoute('entree');
        }
        }
    }
}
