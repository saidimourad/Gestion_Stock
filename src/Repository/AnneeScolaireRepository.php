<?php

namespace App\Repository;

use App\Entity\AnneeScolaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AnneeScolaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnneeScolaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnneeScolaire[]    findAll()
 * @method AnneeScolaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnneeScolaireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AnneeScolaire::class);
    }


    public function rendreencours($id)
    {

      $qb1 = $this->getEntityManager()->createQueryBuilder();
        $qb1->update('App\Entity\AnneeScolaire','e')
            ->set('e.encours', '0')
            ->getQuery()
            ->execute();

        $qb2 = $this->getEntityManager()->createQueryBuilder();
        $qb2->update('App\Entity\AnneeScolaire','e')
            ->set('e.actif', '1')
            ->where('e.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
            ->execute();

     $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->update('App\Entity\AnneeScolaire','e')
            ->set('e.encours', '1')
            ->where('e.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
            ->execute();


    }

    public function activer_annee($id)
    {

        $qb2 = $this->getEntityManager()->createQueryBuilder();
        $qb2->update('App\Entity\AnneeScolaire', 'e')
            ->set('e.actif', '1')
            ->where('e.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
            ->execute();
    }
    public function deactiver_annee($id)
    {

        $qb2 = $this->getEntityManager()->createQueryBuilder();
        $qb2->update('App\Entity\AnneeScolaire', 'e')
            ->set('e.actif', '0')
            ->where('e.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
            ->execute();
    }

    public function encours()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.encours = :val1')
            ->andWhere('a.actif = :val2')
            ->setParameter('val1', '1')
            ->setParameter('val2', '1')
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return AnneeScolaire[] Returns an array of AnneeScolaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnneeScolaire
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
