<?php

namespace App\Repository;
use App\Repository\NegociationRepository;

use App\Entity\Annonceinvestissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Annonceinvestissement>
 *
 * @method Annonceinvestissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonceinvestissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonceinvestissement[]    findAll()
 * @method Annonceinvestissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceinvestissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonceinvestissement::class);
    }

    public function isAnnonceInUse(Annonceinvestissement $annonceinvestissement): bool
    {
        return $this->createQueryBuilder('a')
        ->select('COUNT(n.id)')
        ->leftJoin('App\Entity\Negociation', 'n', 'WITH', 'n.idannonce = a.idannonce')
        ->andWhere('a = :annonceinvestissement')
        ->setParameter('annonceinvestissement', $annonceinvestissement)
        ->getQuery()
        ->getSingleScalarResult() > 0;
        
    }
    public function countNegotiationsByAnnonceId(int $annonceId): int
{
    return $this->createQueryBuilder('a')
        ->select('COUNT(n.id)')
        ->leftJoin('App\Entity\Negociation', 'n', 'WITH', 'n.idannonce = a.idannonce')
        ->andWhere('a.idannonce = :annonceId')
        ->setParameter('annonceId', $annonceId)
        ->getQuery()
        ->getSingleScalarResult();
}

//    /**
//     * @return Annonceinvestissement[] Returns an array of Annonceinvestissement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Annonceinvestissement
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
/**
     * Check if an Annonceinvestissement is associated with any negotiations.
     *
     * @param Annonceinvestissement $annonceinvestissement
     *
     * @return bool
     */
    public function hasAssociatedNegotiations(Annonceinvestissement $annonceinvestissement): bool
{
    return $this->createQueryBuilder('a')
        ->select('COUNT(n.id)')
        ->leftJoin('App\Entity\Negotiation', 'n', 'WITH', 'n.annonceinvestissement = a.idannonce') // Assuming Negotiation entity and field, adjust as needed
        ->andWhere('a = :annonceinvestissement')
        ->setParameter('annonceinvestissement', $annonceinvestissement)
        ->getQuery()
        ->getSingleScalarResult() > 0;
}
}
