<?php

namespace App\Repository;

use App\Entity\Lingecommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Lingecommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lingecommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lingecommande[]    findAll()
 * @method Lingecommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LingecommandeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Lingecommande::class);
    }


    public function search($id) {
        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.commande','ent')
            ->addSelect('ent');

        $qb->select('e')
            ->where('ent.id = ?1')
            ->setParameter(1,$id);

        return $qb->getQuery()->getResult();
    }
    // /**
    //  * @return Lingecommande[] Returns an array of Lingecommande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lingecommande
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
