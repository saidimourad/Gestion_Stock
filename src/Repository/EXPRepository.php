<?php

namespace App\Repository;

use App\Entity\EXP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EXP|null find($id, $lockMode = null, $lockVersion = null)
 * @method EXP|null findOneBy(array $criteria, array $orderBy = null)
 * @method EXP[]    findAll()
 * @method EXP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EXPRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EXP::class);
    }

    // /**
    //  * @return EXP[] Returns an array of EXP objects
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
    public function findOneBySomeField($value): ?EXP
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
