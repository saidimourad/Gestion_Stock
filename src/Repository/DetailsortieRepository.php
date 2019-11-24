<?php

namespace App\Repository;

use App\Entity\Detailsortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Detailsortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Detailsortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Detailsortie[]    findAll()
 * @method Detailsortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailsortieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Detailsortie::class);
    }





    public function search($id) {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.sortie','ent')
            ->addSelect('ent');

        $qb->select('e')
            ->where('ent.id = ?1')
            ->setParameter(1,$id);

        return $qb->getQuery()->getResult();
    }

    public function sommeSortie($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT SUM ( e.qtesortie) AS  total from App\Entity\Detailsortie e where e.sortie = :id ') ;
        $query->setParameter('id', $id);
        return $query->getSingleResult();


    }

    // /**
    //  * @return Detailsortie[] Returns an array of Detailsortie objects
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
    public function findOneBySomeField($value): ?Detailsortie
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
