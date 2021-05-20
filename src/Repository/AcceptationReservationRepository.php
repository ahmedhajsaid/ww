<?php

namespace App\Repository;

use App\Entity\AcceptationReservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AcceptationReservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AcceptationReservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AcceptationReservation[]    findAll()
 * @method AcceptationReservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AcceptationReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AcceptationReservation::class);
    }

    // /**
    //  * @return AcceptationReservation[] Returns an array of AcceptationReservation objects
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
    public function findOneBySomeField($value): ?AcceptationReservation
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
