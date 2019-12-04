<?php

namespace App\Repository;

use App\Entity\User1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User1|null find($id, $lockMode = null, $lockVersion = null)
 * @method User1|null findOneBy(array $criteria, array $orderBy = null)
 * @method User1[]    findAll()
 * @method User1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class User1Repository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User1::class);
    }

    // /**
    //  * @return User1[] Returns an array of User1 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User1
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
