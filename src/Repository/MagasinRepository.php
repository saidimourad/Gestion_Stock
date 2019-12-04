<?php

namespace App\Repository;

use App\Entity\Magasin;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Magasin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Magasin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Magasin[]    findAll()
 * @method Magasin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MagasinRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Magasin::class);
    }




    public function findMagasinByuserCB($id)
    {
        $entityManager = $this->getEntityManager();

            $query = $entityManager->createQuery(

                'SELECT mg from App\Entity\AffecterChefbureau aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an ,App\Entity\Region r  WHERE r.id = mg.region and r.id=aff.region  and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1');
            $query->setParameter('id', $id);


        return $query->execute();

        // return $query->getSingleResult();


    }


    public function findMagasinByuserCU($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT mg from App\Entity\AffecterChefunite aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an ,App\Entity\Region r  WHERE r.id = mg.region and r.id=aff.region  and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1');
        $query->setParameter('id', $id);


        return $query->execute();

        // return $query->getSingleResult();


    }



    public function findMagasinEncours($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT mg from App\Entity\AffecterMagasinier aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an WHERE mg.id = aff.magasin and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1') ;

        $query->setParameter('id', $id);
        return $query->execute();

    }




    // /**
    //  * @return Magasin[] Returns an array of Magasin objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Magasin
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
