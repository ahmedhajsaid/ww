<?php

namespace App\Repository;

use App\Entity\PenaliteJoueur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PenaliteJoueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method PenaliteJoueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method PenaliteJoueur[]    findAll()
 * @method PenaliteJoueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PenaliteJoueurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PenaliteJoueur::class);
    }

    // /**
    //  * @return PenaliteJoueur[] Returns an array of PenaliteJoueur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PenaliteJoueur
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
