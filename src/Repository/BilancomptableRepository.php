<?php

namespace App\Repository;

use App\Entity\Bilancomptable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bilancomptable>
 *
 * @method Bilancomptable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bilancomptable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bilancomptable[]    findAll()
 * @method Bilancomptable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilancomptableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bilancomptable::class);
    }

//    /**
//     * @return Bilancomptable[] Returns an array of Bilancomptable objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bilancomptable
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
