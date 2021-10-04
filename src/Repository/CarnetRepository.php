<?php

namespace App\Repository;

use App\Entity\Carnet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Carnet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carnet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carnet[]    findAll()
 * @method Carnet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarnetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carnet::class);
    }

    // /**
    //  * @return Carnet[] Returns an array of Carnet objects
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


    public function findOneBySomeField($nom,$prenom,$telephone)
    {
        return $this->createQueryBuilder('c')
            ->select('c as carnet,count(c.telephone) as nbr')
            ->where('c.prenom = :prenom')
            ->orWhere('c.nom = :nom')
            ->orWhere('c.telephone = :telephone')
            ->setParameter('telephone',(int)$telephone )
            ->setParameter('nom',$nom )
            ->setParameter('prenom',$prenom )
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
