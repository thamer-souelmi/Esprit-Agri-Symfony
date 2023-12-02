<?php

namespace App\Repository;

use App\Entity\Annoncerecrutement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Controller\AnnoncerecrutementController;
use Doctrine\ORM\QueryBuilder;


/**
 * @extends ServiceEntityRepository<Annoncerecrutement>
 *
 * @method Annoncerecrutement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annoncerecrutement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annoncerecrutement[]    findAll()
 * @method Annoncerecrutement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnoncerecrutementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annoncerecrutement::class);
    }


    public function filterByDateOrAlphabetical($sortBy = 'date', $sortOrder = 'asc'): array
    {
        $queryBuilder = $this->createQueryBuilder('a');
    
        if ($sortBy === 'date') {
            $queryBuilder->orderBy('a.datePub', $sortOrder);
        } elseif ($sortBy === 'alphabetique') {
            $queryBuilder->orderBy('a.posteDemande', $sortOrder);
        } else {
            $queryBuilder->orderBy('a.datePub', 'asc');
        }
    
        return $queryBuilder->getQuery()->getResult();
    }
    

    public function searchByPosteContratLoca($searchQuery, $filter1): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->where('a.posteDemande LIKE :searchQuery')
            ->orWhere('a.typeContrat LIKE :searchQuery')
            ->orWhere('a.localisation LIKE :searchQuery')
            ->setParameter('searchQuery', '%' . $searchQuery . '%');

        if ($filter1) {
            $queryBuilder->andWhere('a.filter1 = :filter1')
                ->setParameter('filter1', $filter1);
        }

        return $queryBuilder;
    }                       

    /*public function save(Annoncerecrutement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }*/
//    /**
//     * @return Annoncerecrutement[] Returns an array of Annoncerecrutement objects
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

//    public function findOneBySomeField($value): ?Annoncerecrutement
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

public function isUsedByCandidature(Annoncerecrutement $annoncerecrutement): bool
{
    $qb = $this->createQueryBuilder('a');
    $qb->select('COUNT(c.idcandidature)');
    $qb->leftJoin('a.candidatures', 'c');
    $qb->where('a = :annoncerecrutement');
    $qb->setParameter('annoncerecrutement', $annoncerecrutement);

    return (int) $qb->getQuery()->getSingleScalarResult() > 0;
}
}
