<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\User;
use App\Form\CommandeType;
use App\Form\ValidCommandeType;
use App\Repository\AffecterChefbureauRepository;
use App\Repository\CommandeRepository;
use App\Repository\LingecommandeRepository;
use App\Repository\MagasinRepository;
use App\Service\decodeID;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Repository\AffecterChefuniteRepository;
use App\Repository\EntreeRepository;
use Dompdf\Dompdf;

use Doctrine\Common\Collections\ArrayCollection;


class CommandeController extends AbstractController
{

    /**
     * @Security("is_granted('ROLE_CHEFBUREAU')")
     * @Security("has_role('ROLE_CHEFBUREAU') ")
     * @Route("/newcommande", name="newcommande")

     */
    public function indexActionNew(Request $request,AffecterChefbureauRepository $affchb)
    {
        $rs = $affchb->findAffChefB($this->getUser()->getId());
        if (!$rs) {
            $message = "Vérifier si vous êtes affecter à cette année";
            return $this->render('security/500.html.twig', array(
                'message' => $message));
        } else {
            $form = $this->createForm(CommandeType::class);
            return $this->render('commande/new.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    /**
     *  @Security("is_granted('ROLE_CHEFBUREAU')")
     * @Security("has_role('ROLE_CHEFBUREAU') ")
     * @Route("addcommande", name="addcommande")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexActioncreates(Request $request, CommandeRepository $commandeRepository,AffecterChefbureauRepository $affchb,decodeID $decodeID)
    {
        $rs = $affchb->findAffChefB($this->getUser()->getId());
        if (!$rs) {
            $message = "Vérifier si vous êtes affecter à cette année";
            return $this->render('security/500.html.twig', array(
                'message' => $message));
        } else {
            $form = $this->createForm(CommandeType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $commande = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $commande->setUserchb($this->getUser());
                $commande->setRefCommande($commandeRepository->maxid() + 1);
                $commande->setIsLivre(0);
                $commande->setIsAccept(0);
                $commande->setIsValid(0);
                $commande->setDateCommande(new \DateTime());
                $em->persist($commande);
                $em->flush();
                $this->addFlash('success', "Opération d'ajout avec succées");
                return $this->redirect($this->generateUrl('showcommande', array('id' => (base64_encode($commande->getId()*$decodeID->getDecode())))));
            }
            return $this->render('commande/new.html.twig', ['form' => $form->createView()]);

        }
    }

    /**
     *  @Security("is_granted('ROLE_CHEFBUREAU')")
     * Security("has_role('ROLE_CHEFBUREAU') ")
     * @Route("commande/update/{id}", name="updatecommande")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexupdateAction(Request $request, $id,  CommandeRepository $entreeRepository,AffecterChefbureauRepository $affchb,decodeID $decodeID)
    {
        $rs = $affchb->findAffChefB($this->getUser()->getId());
        if (!$rs) {
            $message = "Vérifier si vous êtes affecter à cette année";
            return $this->render('security/500.html.twig', array(
                'message' => $message));
        } else {

            $em = $this->getDoctrine()->getManager();
            $commande = new Commande();
            $commande = $em->getRepository(Commande::class)->findOneBy(['id' => (base64_decode($id)/$decodeID->getDecode())]);
            //   $user->setFullname('OverSeas media');
            // save the records that are in the database first to compare them with the new one the user sent
            // make sure this line comes before the $form->handleRequest();
            $orignalDetails = new ArrayCollection();
            foreach ($commande->getLingecommandes() as $detail) {
                $orignalDetails->add($detail);
            }
            $form = $this->createForm(CommandeType::class, $commande);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                // get rid of the ones that the user got rid of in the interface (DOM)
                foreach ($orignalDetails as $detail) {

                    if ($commande->getLingecommandes()->contains($detail) === false) {
                        $em->remove($detail);
                    }
                }
                $commande->setDateCommande(new \DateTime());
                $em->persist($commande);
                $em->flush();
                $this->addFlash('success', "Opération de mise à jours avec succées");
                return $this->redirect($this->generateUrl('showcommande', array('id' => (base64_encode($commande->getId()*$decodeID->getDecode())))));
            }
            // replace this example code with whatever you need
            return $this->render('commande/update.html.twig', [
                'form' => $form->createView(), 'commande' => $commande
            ]);
        }
    }


    /**
     *@Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFUNITE')or is_granted('ROLE_MAGASINIER')or is_granted('ROLE_CHEFBUREAU') or is_granted('ROLE_FOURNISSEUR')")

     * @Route("/mescommande", name="mescommande")
     */
    public function mescommande(CommandeRepository $commandeRepository ,MagasinRepository $magasinReposotory,AffecterChefuniteRepository $affchu, EntreeRepository $entreeRepository, AffecterChefbureauRepository $affchb)
    {
        $roles = $this->getUser()->getRoles();
        if ($roles['0'] == 'ROLE_FOURNISSEUR') {
            $commmande = $commandeRepository->findCommandeByFR($this->getUser()->getId());
            return $this->render('commande/mescommande.html.twig', array('commandes' => $commmande));
        } elseif ($roles['0'] == 'ROLE_CHEFBUREAU') {

            $rs = $affchb->findAffChefB($this->getUser()->getId());
            if (!$rs) {
                $message = "Vérifier si vous êtes affecter à cette année";
                return $this->render('security/500.html.twig', array(
                    'message' => $message));
            } else {

                $commmande = $commandeRepository->findCommandeByCB($this->getUser()->getId());
                return $this->render('commande/mescommande.html.twig', array('commandes' => $commmande));
            }

        } elseif ($roles['0'] == 'ROLE_CHEFUNITE') {

            $rs = $affchu->findAffChefU($this->getUser()->getId());
            if (!$rs) {
                $message = "Vérifier si vous êtes affecter à cette année";
                return $this->render('security/500.html.twig', array(
                    'message' => $message));
            } else {
                $commmande = $commandeRepository->findCommandeByCU($this->getUser()->getId());
                return $this->render('commande/mescommande.html.twig', array('commandes' => $commmande));
            }

        } elseif ($roles['0'] == 'ROLE_MAGASINIER') {

            $rs = $entreeRepository->findMagasinEncours($this->getUser()->getId());
            if (!$rs) {
                //    echo "le tableau est vide.";
                $message = "Vérifier si vous êtes affecter à cette année";
                return $this->render('security/500.html.twig', array(
                    'message' => $message));
            } else {
                $commmande = $commandeRepository->findCommandeByMG($this->getUser()->getId());
                return $this->render('commande/mescommande.html.twig', array('commandes' => $commmande));
            }

        } elseif ($roles['0'] == 'ROLE_ADMIN' or $roles['0'] == 'ROLE_DIRECTEUR') {

            $commmande = $commandeRepository->findCommandeByADM();
            return $this->render('commande/mescommande.html.twig', array('commandes' => $commmande));

        } else {

            $message = "Erreur";
            return $this->render('security/500.html.twig', array(
                'message' => $message

            ));
        }

    }

    /**
     *  @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFUNITE')")
     * @Route("/validercommande/{id}", name="validercommande")
     */
    public function validercommande(CommandeRepository $commandeRepository, $id, LingecommandeRepository $lingecommandeRepository,Request $request,decodeID $decodeID)
    {

       // $form = $this->createForm(ValidCommandeType::class);


        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Commande::class)->find(base64_decode($id)/$decodeID->getDecode());
        $ar_entrees = $lingecommandeRepository->search(base64_decode($id)/$decodeID->getDecode());
        // $somme = $lingecommandeRepository->sommeEntree($id);

        if (!$entity) {

            $message = "Détail n existe pas";
            return $this->render('security/500.html.twig', array(
                'message' => $message));

        }

        $entity = $em->getRepository(Commande::class)->findOneBy(['id' => base64_decode($id)/$decodeID->getDecode()]);
        $form = $this->createForm(ValidCommandeType::class, $entity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entity->setUserchu($this->getUser());

          //  $entity = $em->getRepository(Commande::class)->find($id);
          //  $data = $form->getData();
            //$data = $request->request->("userfr");
          //  $u=$em->getRepository(User::class)->find($data);
          //  $entity->setUserfr($data);
         /*   foreach ($data as $key => $value) {

                   echo $key . " : " . $value . "<br />";
          }*/
          $em->persist($entity);
          $em->flush();
            $this->addFlash('success', "Validation avec succées");
          return $this->redirect($this->generateUrl('showcommande', array('id' => (base64_encode($entity->getId()*$decodeID->getDecode())))));

      }


      return $this->render('commande/validercommande.html.twig', array(
          'entity' => $entity,
          'details' => $ar_entrees,
          'form' => $form->createView()
          /* 'delete_form' => $deleteForm->createView(),*/
        ));


    }




    /**
     *@Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFUNITE')or is_granted('ROLE_MAGASINIER')or is_granted('ROLE_CHEFBUREAU') or is_granted('ROLE_FOURNISSEUR')")
     * @Route("showcommande/{id}", name="showcommande")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function showAction($id,  LingecommandeRepository $lingecommandeRepository, CommandeRepository $commandeRepository,decodeID $decodeID)
    {



            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository(Commande::class)->find(base64_decode($id)/$decodeID->getDecode());
            $ar_entrees = $lingecommandeRepository->search(base64_decode($id)/$decodeID->getDecode());
           // $somme = $lingecommandeRepository->sommeEntree($id);

            if (!$entity) {

                $message = "Détail n existe pas";
                return $this->render('security/500.html.twig', array(
                    'message' => $message));
            }

            return $this->render('commande/show.html.twig', array(
                'entity' => $entity,
                'details' => $ar_entrees,
                /* 'delete_form' => $deleteForm->createView(),*/
            ));
        }

    /**
     *@Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFUNITE')or is_granted('ROLE_MAGASINIER')or is_granted('ROLE_CHEFBUREAU') or is_granted('ROLE_FOURNISSEUR')")
     *
     * @Route("imprimercommande/{id}", name="imprimercommande")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function ImpAction($id,  LingecommandeRepository $lingecommandeRepository, CommandeRepository $entreeRepository,decodeID $decodeID)
    {

/*        $id=(base64_decode($id)/$decodeID->getDecode());*/
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Commande::class)->find(base64_decode($id)/$decodeID->getDecode());
        $ar_details = $lingecommandeRepository->search(base64_decode($id)/$decodeID->getDecode());
        // $somme = $lingecommandeRepository->sommeEntree($id);

        if (!$entity) {

            $message = "Détail n existe pas";
            return $this->render('security/500.html.twig', array(
                'message' => $message));
        }



        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html =  $this->render('commande/imprimer.html.twig', array(
            'entity' => $entity,
            'sorties' => $ar_details,
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

    // }

    /**
     *@Security("is_granted('ROLE_FOURNISSEUR')")

     * @Route("/refusercommande/{id}", name="refusercommande")
     */
    public function activer(CommandeRepository $commandeReposotory ,$id,decodeID $decodeID)
    {
            $commandeReposotory->refusercommande(base64_decode($id)/$decodeID->getDecode(), $this->getUser()->getId());
            return $this->redirectToRoute('mescommande');
    }

    /**
     * @Security("is_granted('ROLE_FOURNISSEUR')")

     * @Route("/acceptercommande/{id}", name="acceptercommande")
     */
    public function desactiver( CommandeRepository $commandeReposotory, $id,decodeID $decodeID)
    {
            $commandeReposotory->acceptercommande(base64_decode($id)/$decodeID->getDecode(), $this->getUser()->getId());
            return $this->redirectToRoute('mescommande');

    }



    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFBUREAU')")
     * @Route("/commande_delete/{id}", name="commande_delete")
     */
    public function supprimer($id ,decodeID $decodeID)
    {

        $em = $this->getDoctrine()->getManager();
        $rep = $this->getDoctrine()->getRepository(Commande::class);
        $entity = $rep->findOneBy(['id' => base64_decode($id)/$decodeID->getDecode()]);

        if (!$entity) {
            throw $this->createNotFoundException('Enregistrement introuvable');
            return new Response('not valid');
        }
        else {

            $em->remove($entity);
            $em->flush();
            return $this->redirectToRoute('mescommande');
        }
    }


}


