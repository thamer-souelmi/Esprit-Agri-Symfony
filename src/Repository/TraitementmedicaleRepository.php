<?php

namespace App\Repository;

use App\Entity\Traitementmedicale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Traitementmedicale>
 *
 * @method Traitementmedicale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Traitementmedicale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Traitementmedicale[]    findAll()
 * @method Traitementmedicale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TraitementmedicaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Traitementmedicale::class);
    }

//    /**
//     * @return Traitementmedicale[] Returns an array of Traitementmedicale objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Traitementmedicale
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
