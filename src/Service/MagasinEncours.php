<?php
/**
 * Created by PhpStorm.
 * User: PC
 * Date: 18/11/2019
 * Time: 10:52
 */

namespace App\Service;
use App\Entity\Magasin;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Security;


class MagasinEncours extends \Twig\Extension\AbstractExtension implements \Twig\Extension\GlobalsInterface
{
    protected $em;
    protected $security;public function __construct(EntityManager $em,  Security $security)
    {
        $this->em = $em;
        $this->security = $security;
    }

    public function getGlobals()
    {
       // if (isset($this->security->getUser()->getRoles())) {


       // if ($this->security->getUser()->getRoles() != null) {
          //  $roles = $this->security->getUser()->getRoles();

         //   if ($roles['0'] == 'ROLE_MAGASINIER') {

                /*  }
                 if ($this->security->getUser()->getRoles() != null) {*/
             //   $magasin = $this->em->getRepository(Magasin::class)->findMagasinEncours($this->security->getUser()->getId());
                  $magasin = $this->em->getRepository(Magasin::class)->findMagasinEncours(11);

                $result = [];
                foreach ($magasin as $cf) {
                    $result[0] = $cf->getDesignation();
                }
                return array(
                    'app_magasin' => $result,
                );
            }
      //  }
  //  }
    //}

    public function getName() {
        return 'config_extension';
    }
}