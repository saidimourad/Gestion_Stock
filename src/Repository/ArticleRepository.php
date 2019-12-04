<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function search($article) {
        $qb = $this->createQueryBuilder('a');
        $qb->select('a')
            ->where('a.nom_art = ?1')
            ->setParameter(1,$article)
             ->getQuery()
            ->getResult();
       // return $qb->getQuery()->getSingleResult();
    }


    public function findArticleByuser($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

           // 'SELECT mg from App\Entity\AffecterChefbureau aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an ,App\Entity\Region r  WHERE r.id = mg.region and r.id=aff.region  and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1') ;
            'SELECT a FROM   App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join App\Entity\User u join  App\Entity\AnneeScolaire an join App\Entity\Entree ent  join App\Entity\AffecterMagasinier aff  join App\Entity\Magasin mg  WHERE mg.id=ent.magasin and  mg.id = aff.magasin and aff.user = u.id and c.id = a.categorie and  a.id = de.article and   ent.id=de.entree   and u.id = :id and an.id = ent.anneeScolaire and aff.anneeScolaire=an.id and an.encours=1 and an.actif=1  group by a.nom_art ');


        $query->setParameter('id', $id);
        return $query->execute();
        // return $query->getSingleResult();


    }



    // /**
    //  * @return Article[] Returns an array of Article objects
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
    public function findOneBySomeField($value): ?Article
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
