<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Sortie::class);
    }




    public function findMagasinEncours($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT mg.id from App\Entity\AffecterMagasinier aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an WHERE mg.id = aff.magasin and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1') ;

        $query->setParameter('id', $id);
        return $query->execute();


    }


    public function listesortie($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT sortie from App\Entity\Sortie sortie, App\Entity\User u,  App\Entity\AnneeScolaire an where u.id=sortie.user and u.id = :id and an.id = sortie.anneeScolaire and an.encours=1 and an.actif=1') ;

        $query->setParameter('id', $id);
        return $query->execute();


    }

    public function maxid()
    {

        $qb = $this->createQueryBuilder('ref_sortie')->select('MAX(ref_sortie)');
        return $qb->getQuery()->getSingleScalarResult();

    }


    public function testsortie($id, $article)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

         //   'SELECT c.nom_cat, a.id , a.nom_art, a.unite, a.qte_min, SUM(de.qteentree/2) as entree , (select SUM(ds.qtesortie) from App\Entity\Detailsortie ds join App\Entity\Sortie srt where ds.article =de.article and mg.id=ent.magasin and mg.id=srt.magasin and mg.id = aff.magasin and aff.user = u.id and c.id = a.categorie and  a.id = de.article and  a.id = ds.article and ds.sortie =srt.id and ent.id=de.entree  and u.id = ent.entuser and u.id = :id and an.id = ent.anneeScolaire and an.encours=1 and an.actif=1) as sortie FROM   App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join App\Entity\User u join  App\Entity\AnneeScolaire an join App\Entity\Entree ent  join App\Entity\AffecterMagasinier aff  join App\Entity\Magasin mg  WHERE mg.id=ent.magasin and  mg.id = aff.magasin and aff.user = u.id and c.id = a.categorie and  a.id = de.article and   ent.id=de.entree   and u.id = :id and a.id = :article and an.id = ent.anneeScolaire and an.encours=1 and an.actif=1  group by a.nom_art ');
            'SELECT c.nom_cat, a.id , a.nom_art, a.unite, a.qte_min, SUM(de.qteentree) as entree , (select SUM(ds.qtesortie) from App\Entity\Detailsortie ds join App\Entity\Sortie srt where ds.article =de.article and mg.id=ent.magasin and mg.id=srt.magasin and mg.id = aff.magasin and aff.user = u.id and c.id = a.categorie and  a.id = de.article and  a.id = ds.article and ds.sortie =srt.id and ent.id=de.entree  and u.id = ent.entuser and u.id = :id and an.id = ent.anneeScolaire and aff.anneeScolaire=an.id and  an.encours=1 and an.actif=1) as sortie FROM   App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join App\Entity\User u join  App\Entity\AnneeScolaire an join App\Entity\Entree ent  join App\Entity\AffecterMagasinier aff  join App\Entity\Magasin mg  WHERE mg.id=ent.magasin and  mg.id = aff.magasin and aff.user = u.id and c.id = a.categorie and  a.id = de.article and a.id=:article and  ent.id=de.entree   and u.id = :id and an.id = ent.anneeScolaire  and aff.anneeScolaire=an.id and an.encours=1 and an.actif=1  group by a.nom_art ');

        $query->setParameter('id', $id);
        $query->setParameter('article', $article);
        return $query->execute();


    }


    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
