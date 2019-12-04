<?php

namespace App\Repository;

use App\Entity\AffecterMagasinier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AffecterMagasinier|null find($id, $lockMode = null, $lockVersion = null)
 * @method AffecterMagasinier|null findOneBy(array $criteria, array $orderBy = null)
 * @method AffecterMagasinier[]    findAll()
 * @method AffecterMagasinier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffecterMagasinierRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AffecterMagasinier::class);
    }


    public function findAllannee()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
           //'SELECT c.nom_c, a.nom_art, a.unite, a.qtemin, SUM(e.qte) as entree , SUM(s.qte) as sortie FROM App\Entity\Categorie c, App\Entity\Article a,  App\Entity\Entree e  , App\Entity\Sortie s WHERE c.id = a.categorie and  a.id=e.articles and  a.id=s.articles  group by a.nom_art ');
            'SELECT m from App\Entity\AffecterMagasinier m , App\Entity\AnneeScolaire a WHERE a.id = m.anneeScolaire and  a.encours=1 and a.actif=1  ') ;
        return $query->execute();


    }




/**/

          /*$entities = $this->createQueryBuilder('e')
            ->where($qb->expr()->like('e.provinces', ':element'))
            ->setParameter('element', '%' . $element . '%')
            ->getQuery()
            ->getResult()
                      ;*/

    // /**
    //  * @return AffecterMagasinier[] Returns an array of AffecterMagasinier objects
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
    public function findOneBySomeField($value): ?AffecterMagasinier
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
