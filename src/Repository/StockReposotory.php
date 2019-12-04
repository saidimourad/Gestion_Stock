<?php

namespace App\Repository;

use App\Entity\Entree;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Entree|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entree|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entree[]    findAll()
 * @method Entree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockReposotory extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Entree::class);
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

            'SELECT sortie from App\Entity\Sortie sortie, App\Entity\User u,  App\Entity\AnneeScolaire an, App\Entity\AffecterMagasinier aff  ,App\Entity\Magasin  mg where mg.id = aff.magasin and aff.user = u.id and u.id = :id and u.id=sortie.user  and an.id = sortie.anneeScolaire and an.encours=1 and an.actif=1') ;

        $query->setParameter('id', $id);
        return $query->execute();


    }

    public function listeStock($id)
    {
        $entityManager = $this->getEntityManager($id);

        $query = $entityManager->createQuery(

       'SELECT c.nom_cat, a.id , a.nom_art, a.unite, a.qte_min, SUM(de.qteentree) as entree , (select SUM(ds.qtesortie) from App\Entity\Detailsortie ds join App\Entity\Sortie srt where ds.article =de.article and mg.id=ent.magasin and mg.id=srt.magasin and mg.id = aff.magasin and aff.user = u.id and c.id = a.categorie and  a.id = de.article and  a.id = ds.article and ds.sortie =srt.id and ent.id=de.entree  and u.id = ent.entuser and u.id = :id and an.id = ent.anneeScolaire and aff.anneeScolaire=an.id and an.encours=1 and an.actif=1) as sortie FROM   App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join App\Entity\User u join  App\Entity\AnneeScolaire an join App\Entity\Entree ent  join App\Entity\AffecterMagasinier aff  join App\Entity\Magasin mg  WHERE mg.id=ent.magasin and  mg.id = aff.magasin and aff.user = u.id and c.id = a.categorie and  a.id = de.article and   ent.id=de.entree   and u.id = :id and an.id = ent.anneeScolaire and aff.anneeScolaire=an.id and an.encours=1 and an.actif=1  group by a.nom_art ');



        $query->setParameter('id', $id);
        return $query->execute();


    }

    public function listeStockbymagasin($id)
    {
        $entityManager = $this->getEntityManager($id);

        $query = $entityManager->createQuery(

            'SELECT c.nom_cat, a.id , a.nom_art, a.unite, a.qte_min, SUM(de.qteentree) as entree , (select SUM(ds.qtesortie) from App\Entity\Detailsortie ds join App\Entity\Sortie srt where ds.article =de.article and mg.id=ent.magasin and mg.id=srt.magasin and c.id = a.categorie and  a.id = de.article and  a.id = ds.article and ds.sortie =srt.id and ent.id=de.entree   and mg.id = :id and an.id = ent.anneeScolaire  and an.encours=1 and an.actif=1) as sortie FROM   App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join  App\Entity\AnneeScolaire an join App\Entity\Entree ent    join App\Entity\Magasin mg  WHERE mg.id=ent.magasin and   c.id = a.categorie and  a.id = de.article and   ent.id=de.entree   and mg.id = :id and an.id = ent.anneeScolaire and  an.encours=1 and an.actif=1  group by a.nom_art ');


        $query->setParameter('id', $id);
        return $query->execute();


    }



    public function consommationStock($id)
    {
        $entityManager = $this->getEntityManager($id);

        $query = $entityManager->createQuery(

            'SELECT c.nom_cat, a.id , a.nom_art, a.unite, a.qte_min,  SUM(de.qteentree*de.prixentree) as consommation , SUM(de.qteentree) as entree , (select SUM(ds.qtesortie) from App\Entity\Detailsortie ds join App\Entity\Sortie srt where ds.article =de.article and mg.id=ent.magasin and mg.id=srt.magasin and mg.id = aff.magasin and aff.user = u.id and c.id = a.categorie and  a.id = de.article and  a.id = ds.article and ds.sortie =srt.id and ent.id=de.entree  and u.id = ent.entuser and u.id = :id and an.id = ent.anneeScolaire and aff.anneeScolaire=an.id and an.encours=1 and an.actif=1) as sortie FROM   App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join App\Entity\User u join  App\Entity\AnneeScolaire an join App\Entity\Entree ent  join App\Entity\AffecterMagasinier aff  join App\Entity\Magasin mg  WHERE mg.id=ent.magasin and  mg.id = aff.magasin and aff.user = u.id and c.id = a.categorie and  a.id = de.article and   ent.id=de.entree   and u.id = :id and an.id = ent.anneeScolaire and aff.anneeScolaire=an.id and an.encours=1 and an.actif=1  group by a.nom_art ');

        $query->setParameter('id', $id);
        return $query->execute();
    }


    public function sommeConsommation($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

        'SELECT SUM (de.prixentree * de.qteentree) AS  total from App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join App\Entity\User u join  App\Entity\AnneeScolaire an join App\Entity\Entree ent  join App\Entity\AffecterMagasinier aff  join App\Entity\Magasin mg  WHERE mg.id=ent.magasin and  mg.id = aff.magasin and aff.user = u.id and c.id = a.categorie and  a.id = de.article and   ent.id=de.entree   and u.id = :id and an.id = ent.anneeScolaire and aff.anneeScolaire=an.id and an.encours=1 and an.actif=1') ;

        $query->setParameter('id', $id);
        return $query->getSingleResult();


    }




    public function consommationStockMG($id)
    {
        $entityManager = $this->getEntityManager($id);

        $query = $entityManager->createQuery(

            'SELECT c.nom_cat, a.id , a.nom_art, a.unite, a.qte_min,  SUM(de.qteentree*de.prixentree) as consommation , SUM(de.qteentree) as entree , (select SUM(ds.qtesortie) from App\Entity\Detailsortie ds join App\Entity\Sortie srt where ds.article =de.article and mg.id=ent.magasin and mg.id=srt.magasin  and c.id = a.categorie and  a.id = de.article and  a.id = ds.article and ds.sortie =srt.id and ent.id=de.entree  and mg.id = :id and an.id = ent.anneeScolaire  and an.encours=1 and an.actif=1) as sortie FROM   App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join  App\Entity\AnneeScolaire an join App\Entity\Entree ent   join App\Entity\Magasin mg  WHERE mg.id=ent.magasin  and c.id = a.categorie and  a.id = de.article and   ent.id=de.entree   and mg.id = :id and an.id = ent.anneeScolaire  and an.encours=1 and an.actif=1  group by a.nom_art ');

        $query->setParameter('id', $id);
        return $query->execute();
    }


    public function sommeConsommationMG($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT SUM (de.prixentree * de.qteentree) AS  total from App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article  join  App\Entity\AnneeScolaire an join App\Entity\Entree ent   join App\Entity\Magasin mg  WHERE mg.id=ent.magasin and  c.id = a.categorie and  a.id = de.article and   ent.id=de.entree   and mg.id = :id and an.id = ent.anneeScolaire  and an.encours=1 and an.actif=1') ;

        $query->setParameter('id', $id);
        return $query->getSingleResult();


    }






    public function maxid()
    {

        $qb = $this->createQueryBuilder('ref_sortie')->select('MAX(ref_sortie)');
        return $qb->getQuery()->getSingleScalarResult();

    }

    public function besoinStockCB($id)
    {
        $entityManager = $this->getEntityManager($id);

        $query = $entityManager->createQuery(

            'SELECT c.nom_cat, a.id , a.nom_art, a.unite, a.qte_min, mg.designation, SUM(de.qteentree/3) as entree ,(select SUM(lc.qtecommande) from App\Entity\Lingecommande lc join App\Entity\Commande cmd  where cmd.id=lc.commande and  lc.article =de.article and mg.id=cmd.magasin  and an.id = cmd.anneeScolaire  and an.encours=1 and an.actif=1  and cmd.isLivre=0   ) as commande, (select SUM(ds.qtesortie) from App\Entity\Detailsortie ds join App\Entity\Sortie srt where ds.article =de.article and mg.id=ent.magasin and mg.id=srt.magasin and c.id = a.categorie and  a.id = de.article and  a.id = ds.article and ds.sortie =srt.id and ent.id=de.entree   and r.id = mg.region and r.id=aff.region  and aff.user = u.id and u.id = :id and an.id = ent.anneeScolaire  and an.encours=1 and an.actif=1) as sortie FROM   App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join  App\Entity\AnneeScolaire an join App\Entity\Entree ent    join App\Entity\Magasin mg join App\Entity\AffecterChefbureau aff join App\Entity\Region r join App\Entity\User u WHERE mg.id=ent.magasin and   c.id = a.categorie and  a.id = de.article and ent.id=de.entree and r.id = mg.region and r.id=aff.region  and aff.user = u.id and u.id = :id and an.id = ent.anneeScolaire and  an.encours=1 and an.actif=1 GROUP BY  mg.designation,a.nom_art  ');

        $query->setParameter('id', $id);
        return $query->execute();


    }

    public function besoinStockCU($id)
    {
        $entityManager = $this->getEntityManager($id);

        $query = $entityManager->createQuery(

            'SELECT c.nom_cat, a.id , a.nom_art, a.unite, a.qte_min, mg.designation, SUM(de.qteentree/3) as entree ,(select SUM(lc.qtecommande) from App\Entity\Lingecommande lc join App\Entity\Commande cmd  where cmd.id=lc.commande and  lc.article =de.article and mg.id=cmd.magasin  and an.id = cmd.anneeScolaire  and an.encours=1 and an.actif=1  and cmd.isLivre=0   ) as commande, (select SUM(ds.qtesortie) from App\Entity\Detailsortie ds join App\Entity\Sortie srt where ds.article =de.article and mg.id=ent.magasin and mg.id=srt.magasin and c.id = a.categorie and  a.id = de.article and  a.id = ds.article and ds.sortie =srt.id and ent.id=de.entree   and r.id = mg.region and r.id=aff.region  and aff.user = u.id and u.id = :id and an.id = ent.anneeScolaire  and an.encours=1 and an.actif=1) as sortie FROM   App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join  App\Entity\AnneeScolaire an join App\Entity\Entree ent    join App\Entity\Magasin mg join App\Entity\AffecterChefunite aff join App\Entity\Region r join App\Entity\User u WHERE mg.id=ent.magasin and   c.id = a.categorie and  a.id = de.article and ent.id=de.entree and r.id = mg.region and r.id=aff.region  and aff.user = u.id and u.id = :id and an.id = ent.anneeScolaire and  an.encours=1 and an.actif=1 GROUP BY  mg.designation,a.nom_art  ');

        $query->setParameter('id', $id);
        return $query->execute();


    }

    public function besoinStockALL()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT c.nom_cat, a.id , a.nom_art, a.unite, a.qte_min, mg.designation, r.designation as region , SUM(de.qteentree) as entree ,(select SUM(lc.qtecommande) from App\Entity\Lingecommande lc join App\Entity\Commande cmd  where cmd.id=lc.commande and  lc.article =de.article and mg.id=cmd.magasin  and an.id = cmd.anneeScolaire  and an.encours=1 and an.actif=1  and cmd.isLivre=0   ) as commande, (select SUM(ds.qtesortie) from App\Entity\Detailsortie ds join App\Entity\Sortie srt where ds.article =de.article and mg.id=ent.magasin and mg.id=srt.magasin and c.id = a.categorie and  a.id = de.article and  a.id = ds.article and ds.sortie =srt.id and ent.id=de.entree   and an.id = ent.anneeScolaire  and an.encours=1 and an.actif=1) as sortie FROM   App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join  App\Entity\AnneeScolaire an join App\Entity\Entree ent    join App\Entity\Magasin mg join App\Entity\Region r   WHERE mg.id=ent.magasin and mg.region=r.id and   c.id = a.categorie and  a.id = de.article and ent.id=de.entree  and an.id = ent.anneeScolaire and  an.encours=1 and an.actif=1 GROUP BY  mg.designation,a.nom_art  ');

       // $query->setParameter('id', $id);
        return $query->execute();


    }






    public function mvnEStock($mg , $id)
    {
        $entityManager = $this->getEntityManager($id);

        $query = $entityManager->createQuery(

            'SELECT  ent ,c.nom_cat, a.id , a.nom_art, ent.refEntree, de.prixentree, ent.dateEntree, a.unite, a.qte_min, de.qteentree ,SUM(de.qteentree) as entree  FROM   App\Entity\Article a  join App\Entity\Categorie c   LEFT JOIN  App\Entity\Detailentree de WITH a.id=de.article   join  App\Entity\AnneeScolaire an join App\Entity\Entree ent   join App\Entity\Magasin mg  WHERE mg.id=ent.magasin and  mg.id = :mg and  c.id = a.categorie and  a.id = de.article and   ent.id=de.entree   and de.article = :id and an.id = ent.anneeScolaire  and an.encours=1 and an.actif=1  group by ent.refEntree ');



        $query->setParameter('mg', $mg);
        $query->setParameter('id', $id);

        return $query->execute();


    }
    public function mvnALLEStock($mg )
    {
        $entityManager = $this->getEntityManager($mg);

        $query = $entityManager->createQuery(


        'SELECT  de   FROM     App\Entity\Detailentree de   join  App\Entity\AnneeScolaire an join App\Entity\Entree ent   join App\Entity\Magasin mg  WHERE de.entree=ent.id and ent.magasin=mg.id and   mg.id = :mg and  an.encours=1 and an.actif=1  group by de.id');


        $query->setParameter('mg', $mg);
       // $query->setParameter('id', $id);

        return $query->execute();


    }



    public function mvnALLSStock($mg )
    {
        $entityManager = $this->getEntityManager($mg);

        $query = $entityManager->createQuery(


            'SELECT  ds   FROM     App\Entity\Detailsortie ds   join  App\Entity\AnneeScolaire an join App\Entity\Sortie srt   join App\Entity\Magasin mg  WHERE ds.sortie=srt.id and srt.magasin=mg.id and mg.id = :mg and  an.encours=1 and an.actif=1  group by ds.id');


        $query->setParameter('mg', $mg);

        return $query->execute();


    }





    public function mvnALLMGEStock( )
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(



            'SELECT  de   FROM     App\Entity\Detailentree de   join  App\Entity\AnneeScolaire an join App\Entity\Entree ent    WHERE    an.encours=1 and an.actif=1  group by de.id');



        return $query->execute();


    }


    public function mvnALLMGSStock( )
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(


            'SELECT  ds   FROM     App\Entity\Detailsortie ds   join  App\Entity\AnneeScolaire an join App\Entity\Sortie srt   WHERE    an.encours=1 and an.actif=1  group by ds.id');




        return $query->execute();


    }



    /*    public function search($searchParam) {
            extract($searchParam);
            $qb = $this->createQueryBuilder('l')
                ->leftJoin('l.livraison','liv')
                ->addSelect('liv')
                ->leftJoin('liv.fournisseur','f')
                ->addSelect('f')
                ->leftJoin('l.article','ar')
                ->addSelect('ar')
                ->leftJoin('ar.category','cat')
                ->addSelect('cat');

            if(!empty($keyword))
                $qb->andWhere('l.quantite like :keyword or l.prix like :keyword or l.duree like :keyword or l.dateGarantie like :keyword  or liv.refMarche like :keyword or ar.ref like :keyword or ar.libele like :keyword')
                    ->setParameter('keyword', '%'.$keyword.'%');
            if(!empty($ids))
                $qb->andWhere('l.id in (:ids)')->setParameter('ids', $ids);
            if(!empty($quantite))
                $qb->andWhere('l.quantite like :quantite')->setParameter('quantite', $quantite);
            if(!empty($prix))
                $qb->andWhere('l.prix like :prix')->setParameter('prix', $prix);
            if(!empty($livraison))
                $qb->andWhere('liv.refMarche = :refMarche')->setParameter('refMarche', $livraison);
            if(!empty($article))
                $qb->andWhere('ar.ref = :ref')->setParameter('ref', $article);
            if(!empty($sortBy)){
                $sortBy = in_array($sortBy, array('refMarche','livraison_id','article_id')) ? $sortBy : 'id';
                $sortDir = ($sortDir == 'DESC') ? 'DESC' : 'ASC';
                $qb->orderBy('liv.' . $sortBy, $sortDir);
            }
            if(!empty($perPage)) $qb->setFirstResult(($page - 1) * $perPage)->setMaxResults($perPage);

            return new Paginator($qb->getQuery());
        }*/
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
