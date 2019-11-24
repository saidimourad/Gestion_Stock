<?php

namespace App\Controller;

use App\Entity\Entree;
use App\Entity\Magasin;
use App\Form\SelectAllMagasinType;
use App\Form\SelectmagasinCUType;
use App\Form\SelectmagasinType;
use App\Repository\AffecterChefbureauRepository;
use App\Repository\AffecterChefuniteRepository;
use App\Repository\EntreeRepository;
use App\Repository\MagasinRepository;
use App\Repository\StockReposotory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;

class StockController extends AbstractController
{


    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFUNITE')or is_granted('ROLE_MAGASINIER')or is_granted('ROLE_CHEFBUREAU')")
     * @Route("/stock", name="stock")
     */

    public function indexstock(EntreeRepository $entreeRepository,AffecterChefuniteRepository $affchu, StockReposotory $stockReposotory, AffecterChefbureauRepository $affchb ,   Request $request)
    {


        $roles=$this->getUser()->getRoles();

        if($roles['0']=='ROLE_MAGASINIER')
        {
            $rs= $entreeRepository->findMagasinEncours($this->getUser()->getId());
            if (!$rs) {
                //    echo "le tableau est vide.";
                $message = "Vérifier si vous êtes affecter à cette année";
                return $this->render('security/500.html.twig', array(
                    'message' => $message ));
                  }
            else{
                $stock= $stockReposotory->listeStock($this->getUser()->getId());

                return $this->render('stock/index.html.twig', array('stock' => $stock));
                }

            //echo $roles['0'];
        }
        elseif ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR' or $roles['0']=='ROLE_CHEFBUREAU' or $roles['0']=='ROLE_CHEFUNITE')
        {
            //$form = $this->createForm(SelectmagasinType::class);
          //  $form->handleRequest($request);
            $stock=null;
            if ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR' ) {
                 $form = $this->createForm(SelectAllMagasinType::class);
               // $form = $this->createForm(SelectmagasinType::class);

            }

            elseif ( $roles['0']=='ROLE_CHEFBUREAU' )
            {
                $rs= $affchb->findAffChefB($this->getUser()->getId());
                if (!$rs) {
                    $message = "Vérifier si vous êtes affecter à cette année";
                    return $this->render('security/500.html.twig', array(
                        'message' => $message ));
                }
                else{
                    $form = $this->createForm(SelectmagasinType::class);
                }
            }
            elseif (  $roles['0']=='ROLE_CHEFUNITE')
            {
                $rs= $affchu->findAffChefU($this->getUser()->getId());
                if (!$rs) {
                    $message = "Vérifier si vous êtes affecter à cette année";
                    return $this->render('security/500.html.twig', array(
                        'message' => $message ));
                }
                else{
                    $form = $this->createForm(SelectmagasinCUType::class);
                }


            }

          //  $stock= $this->getDoctrine()->getRepository(Entree::class)->findAll();
            if( isset($_POST["afficher"]) ) {
                $id = $request->get('magasin');

                $stock= $stockReposotory->listeStockbymagasin($id);
                return $this->render('stock/index.html.twig', array('stock' => $stock, 'form' => $form->createView()));

            }
            else{

                return $this->render('stock/index.html.twig', array('stock' => $stock, 'form' => $form->createView()));
            }



        }


    }




    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFUNITE')or is_granted('ROLE_MAGASINIER')or is_granted('ROLE_CHEFBUREAU')")
     * @Route("/consommation", name="consommation" )
     */

    public function indexconsommation(EntreeRepository $entreeRepository, StockReposotory $stockReposotory,  Request $request,AffecterChefuniteRepository $affchu,  AffecterChefbureauRepository $affchb)
    {


       $roles=$this->getUser()->getRoles();

        if($roles['0']=='ROLE_MAGASINIER')
        {

            $rs= $entreeRepository->findMagasinEncours($this->getUser()->getId());
            if (!$rs) {
                //    echo "le tableau est vide.";
                $message = "Verifier si vous etes affecter";
                return $this->render('security/500.html.twig', array(
                    'message' => $message ));

            }
            else{
                $stock= $stockReposotory->consommationStock($this->getUser()->getId());
                $somme= $stockReposotory->sommeConsommation($this->getUser()->getId());

                foreach ($somme as $key => $value) {

                    $somme= $value;
                }

                return $this->render('stock/consommation.html.twig', array('stock' => $stock, 'somme' => $somme));
            }


        }
        elseif ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR' or $roles['0']=='ROLE_CHEFBUREAU' or $roles['0']=='ROLE_CHEFUNITE')
        {
            $stock=null;
            if ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR' ) {
                $form = $this->createForm(SelectAllMagasinType::class);


            }

            elseif ( $roles['0']=='ROLE_CHEFBUREAU' )
            {
                $rs= $affchb->findAffChefB($this->getUser()->getId());
                if (!$rs) {
                    $message = "Vérifier si vous êtes affecter à cette année";
                    return $this->render('security/500.html.twig', array(
                        'message' => $message ));
                }
                else{
                    $form = $this->createForm(SelectmagasinType::class);
                }

            }
            elseif ( $roles['0']=='ROLE_CHEFUNITE')
            {
                $rs= $affchu->findAffChefU($this->getUser()->getId());
                if (!$rs) {
                    $message = "Vérifier si vous êtes affecter à cette année";
                    return $this->render('security/500.html.twig', array(
                        'message' => $message ));
                }
                else{
                    $form = $this->createForm(SelectmagasinCUType::class);
                }


            }


            if( isset($_POST["afficher"]) ) {
                $id = $request->get('magasin');

                $stock= $stockReposotory->listeStockbymagasin($id);
                return $this->render('stock/consommation.html.twig', array('stock' => $stock, 'form' => $form->createView()));

            }
            else{

                return $this->render('stock/consommation.html.twig', array('stock' => $stock, 'form' => $form->createView()));
            }



        }


    }


    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFUNITE')or is_granted('ROLE_MAGASINIER')or is_granted('ROLE_CHEFBUREAU')")
     * @Route("/consommationafficher", name="consommationafficher", methods={"POST"})

     */

    public function indexAfficherConsommation(EntreeRepository $entreeRepository, StockReposotory $stockReposotory,  Request $request, MagasinRepository $magasinReposotory)
    {
        $roles=$this->getUser()->getRoles();
        // $magasin = new Magasin();

        if ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR' or $roles['0']=='ROLE_CHEFBUREAU' or $roles['0']=='ROLE_CHEFUNITE')
        {
            $stock=null;

            if ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR' ) {
                $form = $this->createForm(SelectAllMagasinType::class);
                // $form = $this->createForm(SelectmagasinType::class);

            }

            elseif ( $roles['0']=='ROLE_CHEFBUREAU')
            {
                $form = $this->createForm(SelectmagasinType::class);

            }
            elseif ( $roles['0']=='ROLE_CHEFUNITE')
            {
                $form = $this->createForm(SelectmagasinCUType::class);

            }


            //  $stock= $this->getDoctrine()->getRepository(Entree::class)->findAll();
            if( isset($_POST["afficher"]) &&  isset($_POST["selectmagasin"] )) {

                $magasin = $_POST["selectmagasin"]["magasin"];
            }
            elseif (isset($_POST["afficher"]) &&  isset($_POST["select_all_magasin"] )) {
                $magasin = $_POST["select_all_magasin"]["magasin"];
            }
            elseif (isset($_POST["afficher"]) &&  isset($_POST["selectmagasin_cu"] )) {
                $magasin = $_POST["selectmagasin_cu"]["magasin"];
            }

            $stock= $stockReposotory->consommationStockMG($magasin);
            $somme= $stockReposotory->sommeConsommationMG($magasin);
            foreach ($somme as $key => $value) {

                $somme= $value;
            }

           // $stock= $stockReposotory->listeStockbymagasin($magasin);

            $infomagasin = $magasinReposotory->findBy(['id' => $magasin]);


            return $this->render('stock/consommation.html.twig', array('stock' => $stock, 'somme'=> $somme,'infomagasin' => $infomagasin, 'form' => $form->createView()));
        }


    }




    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFUNITE')or is_granted('ROLE_MAGASINIER')or is_granted('ROLE_CHEFBUREAU')")
     * @Route("/stockafficher", name="stockaffiche", methods={"POST"})

     */

    public function indexAfficherstock(EntreeRepository $entreeRepository, StockReposotory $stockReposotory,  Request $request, MagasinRepository $magasinReposotory)
    {
        $roles=$this->getUser()->getRoles();
       // $magasin = new Magasin();

    if ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR' or $roles['0']=='ROLE_CHEFBUREAU' or $roles['0']=='ROLE_CHEFUNITE')
    {
        $stock=null;

        if ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR' ) {
           $form = $this->createForm(SelectAllMagasinType::class);
           // $form = $this->createForm(SelectmagasinType::class);

        }

        elseif ( $roles['0']=='ROLE_CHEFBUREAU')
        {
            $form = $this->createForm(SelectmagasinType::class);

        }
        elseif ( $roles['0']=='ROLE_CHEFUNITE')
        {
            $form = $this->createForm(SelectmagasinCUType::class);

        }


        //  $stock= $this->getDoctrine()->getRepository(Entree::class)->findAll();
       if( isset($_POST["afficher"]) &&  isset($_POST["selectmagasin"] )) {

           $magasin = $_POST["selectmagasin"]["magasin"];
       }
        elseif (isset($_POST["afficher"]) &&  isset($_POST["select_all_magasin"] )) {
            $magasin = $_POST["select_all_magasin"]["magasin"];
        }
       elseif (isset($_POST["afficher"]) &&  isset($_POST["selectmagasin_cu"] )) {
           $magasin = $_POST["selectmagasin_cu"]["magasin"];
       }

           $stock= $stockReposotory->listeStockbymagasin($magasin);

          $infomagasin = $magasinReposotory->findBy(['id' => $magasin]);


           return $this->render('stock/index.html.twig', array('stock' => $stock, 'infomagasin' => $infomagasin, 'form' => $form->createView()));
          }


    }


    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFBUREAU') or is_granted('ROLE_CHEFUNITE') ")
     * @Route("/besoin", name="besoin")
     */

    public function indexbesoin( StockReposotory $stockReposotory,AffecterChefuniteRepository $affchu,  AffecterChefbureauRepository $affchb)
    {
        $roles = $this->getUser()->getRoles();
        // $magasin = new Magasin();

        if ( $roles['0'] == 'ROLE_CHEFBUREAU') {
            $rs= $affchb->findAffChefB($this->getUser()->getId());
            if (!$rs) {
                $message = "Vérifier si vous êtes affecter à cette année";
                return $this->render('security/500.html.twig', array(
                    'message' => $message ));
            }
            else{
                $besoin = $stockReposotory->besoinStockCB($this->getUser()->getId());
                return $this->render('stock/besoin.html.twig', array('besoin' => $besoin));            }


        }
        elseif ($roles['0'] == 'ROLE_CHEFUNITE' ) {

            $rs= $affchu->findAffChefU($this->getUser()->getId());
            if (!$rs) {
                $message = "Vérifier si vous êtes affecter à cette année";
                return $this->render('security/500.html.twig', array(
                    'message' => $message ));
            }
            else{
                $besoin = $stockReposotory->besoinStockCU($this->getUser()->getId());
                return $this->render('stock/besoin.html.twig', array('besoin' => $besoin));            }


        }
        elseif ($roles['0'] == 'ROLE_ADMIN' or $roles['0'] == 'ROLE_DIRECTEUR' ) {
            $besoin = $stockReposotory->besoinStockALL();
            return $this->render('stock/besoin.html.twig', array('besoin' => $besoin));
        }
    }



    /**
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     * @Route("/mouvement/entree", name="mouvemententree")
     */

    public function mouvemententree(EntreeRepository $entreeRepository, StockReposotory $stockReposotory,  Request $request, MagasinRepository $magasinReposotory)
    {


        $roles=$this->getUser()->getRoles();

        if($roles['0']=='ROLE_MAGASINIER')
        {

            $rs= $entreeRepository->findMagasinEncours($this->getUser()->getId());
            if (!$rs) {
                //    echo "le tableau est vide.";
                $message = "Verifier si vous etes affecter";
                return $this->render('security/500.html.twig', array(
                    'message' => $message ));

            }
            else{

                foreach ($rs as $key => $value) {
                    //echo $key . " : " . $value . "<br />";
                    $mg = $value;
                }
               // echo $mg['id'];
               // echo $id;

                $magasin =$mg['id'];

                $mventree= $stockReposotory->mvnALLEStock($magasin);

                $infomagasin = $magasinReposotory->findBy(['id' => $magasin]);

                return $this->render('stock/mouvement.html.twig', array('mventree' => $mventree, 'infomagasin' => $infomagasin));

            }


        }
        elseif ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR' ) {

            $mventree= $stockReposotory->mvnALLMGEStock();

            return $this->render('stock/mouvement.html.twig', array('mventree' => $mventree));

        }

    }


    /**
     *  @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_MAGASINIER')")
     * @Route("/mouvement/sortie", name="mouvementsortie")
     */

    public function mouvementsortie(EntreeRepository $entreeRepository, StockReposotory $stockReposotory,  Request $request, MagasinRepository $magasinReposotory)
    {


        $roles=$this->getUser()->getRoles();

        if($roles['0']=='ROLE_MAGASINIER')
        {

            $rs= $entreeRepository->findMagasinEncours($this->getUser()->getId());
            if (!$rs) {
                //    echo "le tableau est vide.";
                $message = "Verifier si vous etes affecter";
                return $this->render('security/500.html.twig', array(
                    'message' => $message ));

            }
            else{

                foreach ($rs as $key => $value) {
                    //echo $key . " : " . $value . "<br />";
                    $mg = $value;
                }
                // echo $mg['id'];
                // echo $id;

                $magasin =$mg['id'];
                //  echo $mg;
                //$mventree= $stockReposotory->mvnEStock($mg, $id);
                $mvsortie= $stockReposotory->mvnALLSStock($magasin);
                $infomagasin = $magasinReposotory->findBy(['id' => $magasin]);


                return $this->render('stock/mouvement.html.twig', array('mvsortie' => $mvsortie, 'infomagasin' => $infomagasin));

            }


        }
          elseif ($roles['0']=='ROLE_ADMIN' or $roles['0']=='ROLE_DIRECTEUR' )
          {
              $mvsortie= $stockReposotory->mvnALLMGSStock();

              return $this->render('stock/mouvement.html.twig', array('mvsortie' => $mvsortie));

                    }



    }


}
