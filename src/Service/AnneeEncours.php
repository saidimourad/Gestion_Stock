<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 12/11/2019
 * Time: 16:11
 */

namespace App\Service;


use App\Entity\AnneeScolaire;
use Doctrine\ORM\EntityManager;


class AnneeEncours extends \Twig\Extension\AbstractExtension implements \Twig\Extension\GlobalsInterface
{
    protected $em;
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getGlobals()
    {
        $annees = $this->em->getRepository(AnneeScolaire::class)->encours();

        $result= [];
        foreach ($annees as $cf) {
            $result[0] = $cf->getDesignation();
        }
        return array(
            'app_config'=> $result,
        );

         }

    public function getName() {
        return 'config_extension';
    }
}