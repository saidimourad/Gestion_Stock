<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Commande::class);
    }



    public function acceptercommande($id, $fr)
    {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->update('App\Entity\Commande','e')
            ->set('e.isAccept', '1')
            ->where('e.id = ?1')
            ->andWhere('e.userfr = ?2')
            ->setParameter('1', $id)
            ->setParameter('2', $fr)
            ->getQuery()
            ->execute();
    }

    public function refusercommande($id, $fr)
    {

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->update('App\Entity\Commande','e')
            ->set('e.isAccept', '2')
            ->where('e.id = ?1')
            ->andWhere('e.userfr = ?2')
            ->setParameter(1, $id)
            ->setParameter('2', $fr)
            ->getQuery()
            ->execute();



    }

    public function maxid()
    {

        $qb = $this->createQueryBuilder('ref_commande')->select('MAX(ref_commande)');
        return $qb->getQuery()->getSingleScalarResult();


    }

    public function findCommandeByCB($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT cmd from App\Entity\Commande cmd , App\Entity\AffecterChefbureau aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an ,App\Entity\Region r  WHERE cmd.userchb =u.id and r.id = mg.region and r.id=aff.region  and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1 ') ;

        $query->setParameter('id', $id);
        return $query->execute();
    }
    public function findCommandeByFR($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT cmd from App\Entity\Commande cmd  , App\Entity\User u, App\Entity\AnneeScolaire an   WHERE cmd.userfr =u.id  and u.id = :id and an.id = cmd.anneeScolaire  and an.actif=1 and an.encours=1') ;

        $query->setParameter('id', $id);
        return $query->execute();
    }

    public function findCommandeByCU($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT cmd from App\Entity\Commande cmd , App\Entity\AffecterChefunite aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an ,App\Entity\Region r  WHERE cmd.magasin=mg.id  and r.id = mg.region and r.id=aff.region  and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1') ;

        $query->setParameter('id', $id);
        return $query->execute();
    }


    public function selectCommandeByMG($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT cmd from App\Entity\Commande cmd , App\Entity\AffecterMagasinier aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an  WHERE cmd.magasin =mg.id and aff.magasin=mg.id and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1 and cmd.isAccept=1 and cmd.isValid=1 and cmd.isLivre=0 and cmd.isAccept=1  ') ;

        //'SELECT cmd from App\Entity\Commande cmd , App\Entity\AffecterMagasinier aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an  WHERE cmd.magasin =mg.id and aff.magasin=mg.id and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1 and cmd.isValid=1 and cmd.isLivre=0   ') ;

        $query->setParameter('id', $id);
        return $query->execute();
    }




    public function UpdateCommandeByMG($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT cmd from App\Entity\Commande cmd , App\Entity\AffecterMagasinier aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an  WHERE cmd.magasin =mg.id and aff.magasin=mg.id and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1 and cmd.isAccept=1 and cmd.isValid=1  ') ;

        //'SELECT cmd from App\Entity\Commande cmd , App\Entity\AffecterMagasinier aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an  WHERE cmd.magasin =mg.id and aff.magasin=mg.id and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1 and cmd.isValid=1 and cmd.isLivre=0   ') ;

        $query->setParameter('id', $id);
        return $query->execute();
    }

    public function findCommandeByMG($id)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT cmd from App\Entity\Commande cmd , App\Entity\AffecterMagasinier aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an  WHERE cmd.magasin =mg.id and aff.magasin=mg.id and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1   ') ;

        //'SELECT cmd from App\Entity\Commande cmd , App\Entity\AffecterMagasinier aff  ,App\Entity\Magasin  mg, App\Entity\User u, App\Entity\AnneeScolaire an  WHERE cmd.magasin =mg.id and aff.magasin=mg.id and aff.user = u.id and u.id = :id and an.id = aff.anneeScolaire  and an.actif=1 and an.encours=1 and cmd.isValid=1 and cmd.isLivre=0   ') ;

        $query->setParameter('id', $id);
        return $query->execute();
    }

    public function findCommandeByADM()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(

            'SELECT cmd from App\Entity\Commande cmd , App\Entity\AnneeScolaire an  WHERE cmd.anneeScolaire = an.id and an.actif=1 and an.encours=1  ') ;

        return $query->execute();
    }






    // /**
    //  * @return Commande[] Returns an array of Commande objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
