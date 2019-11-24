<?php

namespace App\Repository;

use App\Entity\Entree;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use \Datetime;


/**
 * @method Entree|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entree|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entree[]    findAll()
 * @method Entree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntreeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Entree::class);
    }



    public function findMagasinEncours($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
        //'SELECT c.nom_c, a.nom_art, a.unite, a.qtemin, SUM(e.qte) as entree , SUM(s.qte) as sortie FROM App\Entity\Categorie c, App\Entity\Article a,  App\Entity\Entree e  , App\Entity\Sortie s WHERE c.id = a.categorie and  a.id=e.articles and  a.id=s.articles  group by a.nom_art ');
          //  'SELECT mg.id from App\Entity\AffecterMagasinier aff , App\Entity\AnneeScolaire an ,App\Entity\User u ,App\Entity\Magasin mg WHERE an.id = aff.anneeScolaire and mg.id = aff.magasin and aff.user = u.id and an.encours=1 and an.actif=1  ') ;
        //'SELECT mg.id from App\Entity\Magasin mg') ;
        'SELECT mg.id from App\Entity\AffecterMagasinier aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an WHERE mg.id = aff.magasin and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1') ;

        $query->setParameter('id', $id);
       return $query->execute();
       // return $query->getSingleResult();


    }


    public function listeentree($id,  DateTime $date1=null, DateTime  $date2=null)
    {
        $entityManager = $this->getEntityManager();
        if ($id && $date1) {
         //  $date1 = new \DateTime($date1);
           //$date1 = new \DateTime(($date1)->format('y-m-d'));
           // $date1 = new DateTime($date1);

           // $date1= date("Y-m-d", strtotime($date1));
            $query = $entityManager->createQuery(

                'SELECT entree from App\Entity\Entree entree, App\Entity\User u,  App\Entity\AnneeScolaire an where u.id=entree.entuser and u.id = :id and entree.dateEntree > : date1 and an.id = entree.anneeScolaire and an.encours=1 and an.actif=1');

            $query->setParameter('id', $id);
            $query->setParameter('date1', new DateTime($date1));
            return $query->execute();
        }
   elseif ($id && $date2)
   {
      //$date2 = new \DateTime($date2);
       //$date2= date("Y-m-d", strtotime($date2));
       $date2 = new DateTime($date2);

       $query = $entityManager->createQuery(

           'SELECT entree from App\Entity\Entree entree, App\Entity\User u,  App\Entity\AnneeScolaire an where u.id=entree.entuser and u.id = :id and entree.dateEntree < : date1 and an.id = entree.anneeScolaire and an.encours=1 and an.actif=1');

       $query->setParameter('id', $id);
       $query->setParameter('date2', $date2);
       return $query->execute();
   }
   elseif ($id && $date1 && $date2)
   {
      // $date1 = new \DateTime(($date1)->format('y-m-d'));
      // $date2 = new \DateTime(($date2)->format('y-m-d'));
       $date2 = new \DateTime($date2);
       $date1 = new \DateTime($date1);
      // $date1= date("Y-m-d", strtotime($date1));
      // $date2= date("Y-m-d", strtotime($date2));


       $query = $entityManager->createQuery(

           'SELECT entree from App\Entity\Entree entree, App\Entity\User u,  App\Entity\AnneeScolaire an where u.id=entree.entuser and u.id = :id and entree.dateEntree BETWEEN :date1 and :date2 and an.id = entree.anneeScolaire and an.encours=1 and an.actif=1');

       $query->setParameter('id', $id);
       $query->setParameter('date1', new \DateTime($date1));
       $query->setParameter('date2', new \DateTime($date2));
       return $query->execute();

   }
        elseif ($id)
        {
            $query = $entityManager->createQuery(

                'SELECT entree from App\Entity\Entree entree, App\Entity\User u,  App\Entity\AnneeScolaire an where u.id=entree.entuser and u.id = :id and an.id = entree.anneeScolaire and an.encours=1 and an.actif=1');

            $query->setParameter('id', $id);
            return $query->execute();

        }

    }

    public function maxid()
    {

        $qb = $this->createQueryBuilder('ref_entree')->select('MAX(ref_entree)');
        return $qb->getQuery()->getSingleScalarResult();


    }



    // /**
    //  * @return Entree[] Returns an array of Entree objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Entree
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
