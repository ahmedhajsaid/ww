<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
/*
    public function findReservation($cl){
        return $this->createQueryBuilder('reservation')
            ->where('reservation.client = :cl')

            ->setParameter('cl', $cl)
            ->getQuery()
            ->getResult();
    }
*/

    public function findReservation($cl)
    {$id=200;
        return $this->createQueryBuilder('reservation')
            ->where('reservation.client = :cl')
            ->andWhere('reservation.id > :id')
            ->setParameter('cl', $cl)
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }


    public function findResDate($d, $h): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Reservation r
            WHERE r.dateReservation = :d
            and r.heure = :h'
        )->setParameter('d', $d)
        ->setParameter('h',$h);

        // returns an array of Product objects
        return $query->getResult();
    }


}
