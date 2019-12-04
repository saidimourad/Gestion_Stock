<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }



    public function findByRole($value)
    {

        return $this->createQueryBuilder('a')
            ->andWhere('a.roles like :val1')
            ->andWhere('a.isActive = :val2')
            ->setParameter('val1','%'.$value.'%')
            ->setParameter('val2', 1)
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return User[] Returns an array of User objects
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
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function activer_user($id)
    {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->update('App\Entity\User','e')
            ->set('e.isActive', '1')
            ->where('e.id = ?1')
            ->setParameter('1', $id)
            ->getQuery()
            ->execute();
    }

    public function deactiver_user($id)
    {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->update('App\Entity\User','e')
            ->set('e.isActive', '0')
            ->where('e.id = ?1')
            ->setParameter(1, $id)
            ->getQuery()
            ->execute();



    }
}
