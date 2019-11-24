<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    /**
     *
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_DIRECTEUR') or is_granted('ROLE_CHEFUNITE')or is_granted('ROLE_MAGASINIER')or is_granted('ROLE_CHEFBUREAU')or is_granted('ROLE_FOURNISSEUR')")
     * @Route("/home", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
