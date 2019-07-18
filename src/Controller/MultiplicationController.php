<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MultiplicationController extends AbstractController
{
    /**
     * @Route("/multiplications", name="multiplication2")
     */
    public function index2()
    {
        $x = 0;
        $mul=null;
        return $this->render('multiplication/index.html.twig', ['m' => $mul,'v'=>$x]);

    }

    /**
     * @Route("/multiplications/{x}", name="multp")
     */
    public function calcul(int $x)
    {
        for ($i = 0; $i <= 10; $i++) {
            $mul[] = $x * $i;
        }
        return $this->render('multiplication/index.html.twig', ['m' => $mul,'v'=>$x]);


    }


    /**
     * @Route("/", name="home")
     */
    public function home()
    {

        return $this->render('home/index.html.twig');

    }




    /**
     * @Route("/multiplication/{val}", name="tabmult")
     */
    public function index($val = -1)
    {
        return $this->render('multiplication/index.html.twig', [
            'controller_name' => 'TableMultiplicationController', 'val' => $val
        ]);
    }








    }



