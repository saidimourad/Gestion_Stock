<?php

namespace App\Repository;

use App\Entity\Detailentree;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Detailentree|null find($id, $lockMode = null, $lockVersion = null)
 * @method Detailentree|null findOneBy(array $criteria, array $orderBy = null)
 * @method Detailentree[]    findAll()
 * @method Detailentree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailentreeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Detailentree::class);
    }


    public function search($id) {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.entree','ent')
            ->addSelect('ent');

        $qb->select('e')
            ->where('ent.id = ?1')
            ->setParameter(1,$id);

        return $qb->getQuery()->getResult();
    }

    public function sommeEntree($id)
    {
      $entityManager = $this->getEntityManager();

      $query = $entityManager->createQuery(
       'SELECT SUM (e.prixentree * e.qteentree) AS  total from App\Entity\Detailentree e where e.entree = :id ') ;
        $query->setParameter('id', $id);
        return $query->getSingleResult();


      }

/*
    public function nombreArticles()
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('COUNT(a.id) AS nombre')
            ->where('a.actif = true')
            ->orderBy('a.datePublication', 'DESC');

        return $qb->getQuery()->getSingleScalarResult();
    }*/

/*    public function montantTotalParJour()
    {
        $qb = $this->createQueryBuilder('o');

        $qb->select('SUM(o.prixentree) AS total')
            ->where('o.prixentree > 0')
        ->orderBy('o.date', 'ASC');

        return $qb->getQuery()->getArrayResult();
    }*/




    // /**
    //  * @return Detailentree[] Returns an array of Detailentree objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Detailentree
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
