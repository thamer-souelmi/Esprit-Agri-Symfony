<?php

namespace App\Repository;

use App\Entity\Bilanresultat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bilanresultat>
 *
 * @method Bilanresultat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bilanresultat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bilanresultat[]    findAll()
 * @method Bilanresultat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BilanresultatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bilanresultat::class);
    }

//    /**
//     * @return Bilanresultat[] Returns an array of Bilanresultat objects
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

//    public function findOneBySomeField($value): ?Bilanresultat
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
