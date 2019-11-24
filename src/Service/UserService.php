<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 22/11/2019
 * Time: 10:00
 */

namespace App\Service;


use App\Entity\Entree;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;


class UserService
{

    protected $em;
    protected $templating;

    public function __construct(EntityManagerInterface $em, Environment $templating)
    {
        $this->em = $em;
        $this->templating = $templating;
    }

    public function AffecterMagasiner( $id)
    {
        $rs = $this->em->getRepository(Entree::class)->findMagasinEncours($id);

        if (!$rs) {
            //    echo "le tableau est vide.";
            $message = "Vérifier si vous êtes affecter";
            return $this->templating->render('security/500.html.twig', array(
                'message' => $message));
        } else {


            $entrees  = $this->em->getRepository(Entree::class)->listeentree($id, null, null);
            return $this->templating->render('entree/index.html.twig', array('entrees' => $entrees));

          //  return $entrees;

        }
    }

    public function AffecterChBureau()
    {

    }
    public function AffecterChUnite()
    {

    }
}