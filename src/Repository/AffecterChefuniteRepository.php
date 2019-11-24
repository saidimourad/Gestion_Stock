<?php

namespace App\Repository;

use App\Entity\AffecterChefunite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AffecterChefunite|null find($id, $lockMode = null, $lockVersion = null)
 * @method AffecterChefunite|null findOneBy(array $criteria, array $orderBy = null)
 * @method AffecterChefunite[]    findAll()
 * @method AffecterChefunite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffecterChefuniteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AffecterChefunite::class);
    }


    public function findAllannee()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
        //'SELECT c.nom_c, a.nom_art, a.unite, a.qtemin, SUM(e.qte) as entree , SUM(s.qte) as sortie FROM App\Entity\Categorie c, App\Entity\Article a,  App\Entity\Entree e  , App\Entity\Sortie s WHERE c.id = a.categorie and  a.id=e.articles and  a.id=s.articles  group by a.nom_art ');
            'SELECT m from App\Entity\AffecterChefunite m , App\Entity\AnneeScolaire a WHERE a.id = m.anneeScolaire and  a.encours=1 and a.actif=1 ') ;
        return $query->execute();

    }

    public function findAffChefU($id)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT aff.id from App\Entity\AffecterChefunite aff  ,App\Entity\Region  rg, App\Entity\User u, App\Entity\AnneeScolaire an WHERE rg.id = aff.region and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1') ;
        $query->setParameter('id', $id);
        return $query->execute();

    }


    // /**
    //  * @return AffecterChefunite[] Returns an array of AffecterChefunite objects
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
    public function findOneBySomeField($value): ?AffecterChefunite
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
