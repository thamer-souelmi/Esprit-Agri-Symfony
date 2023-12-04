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
// Exemple de méthode de recherche dans le repository
public function search($searchQuery)
{
    return $this->createQueryBuilder('tm')
        ->leftJoin('tm.idvet', 'v') // Remplacez 'idvet' par le nom réel de l'association vers la classe Veterinaire
        ->where('tm.numero = :query OR v.prenomvet = :query')
        ->setParameter('query', $searchQuery)
        ->getQuery()
        ->getResult();
}
public function compterTraitementsParNumero($numeroTraitement)
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->where('t.numero = :numero')
            ->setParameter('numero', $numeroTraitement);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }
    
    public function advancedSearch($startDate, $endDate, $minCost, $maxCost)
    {
        $queryBuilder = $this->createQueryBuilder('t');

        
        if ($startDate) {
            $queryBuilder->andWhere('t.dateintervmed >= :startDate')->setParameter('startDate', $startDate);
        }

        if ($endDate) {
            $queryBuilder->andWhere('t.dateintervmed <= :endDate')->setParameter('endDate', $endDate);
        }

        if ($minCost) {
            $queryBuilder->andWhere('t.coutinterv >= :minCost')->setParameter('minCost', $minCost);
        }

        if ($maxCost) {
            $queryBuilder->andWhere('t.coutinterv <= :maxCost')->setParameter('maxCost', $maxCost);
        }

        $query = $queryBuilder->getQuery();

        dump($query->getSQL());
    dump($query->getParameters());

        return $query->getResult();
    }

    // statistique back: le nombre de traitement medicale realise pour chaque betail a chaque mois

   
/*
 $results = $this->createQueryBuilder('t')
            ->select('t.dateintervmed as date', 'COUNT(t.id) as count')
            ->groupBy('date')
            ->getQuery()
            ->getResult();

        $formattedResults = [];
        foreach ($results as $result) {
            $year = $result['date']->format('Y');
            $formattedResults[$year] = $result['count'];
        }

        return $formattedResults;


        ///////
        SELECT YEAR(t.dateintervmed) as year, COUNT(t.id) as count
FROM App\Entity\Traitementmedicale t
GROUP BY year
*/



    public function countTraitementsParAnnee()
    {
        $query = $this->_em->createQuery('
        SELECT t.dateintervmed as date, COUNT(t.id) as count
        FROM App\Entity\Traitementmedicale t
        GROUP BY t.dateintervmed
    ');

    return $query->getResult();
    }


    public function countTraitementsParVeterinaire()
    {
        $query = $this->_em->createQuery('
            SELECT v.idvet, COUNT(t.id) as count
            FROM App\Entity\Traitementmedicale t
            JOIN t.idvet v
            GROUP BY v.idvet
        ');
    
        return $query->getResult();
    }
}

