<?php

namespace App\Repository;

use App\Entity\Betail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Betail>
 *
 * @method Betail|null find($id, $lockMode = null, $lockVersion = null)
 * @method Betail|null findOneBy(array $criteria, array $orderBy = null)
 * @method Betail[]    findAll()
 * @method Betail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BetailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Betail::class);
    }

//    /**
//     * @return Betail[] Returns an array of Betail objects
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

//    public function findOneBySomeField($value): ?Betail
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
