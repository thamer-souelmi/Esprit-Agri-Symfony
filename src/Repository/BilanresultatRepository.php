<?php

namespace App\Repository;

use App\Entity\Bilanresultat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query;
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
    public function sumOfTotalRevenus(int $idBilanR): float
{
    return $this->createQueryBuilder('br')
        ->select('SUM(br.revenuescultures + br.subvention + br.autrerevenus) as totalRevenus')
        ->where('br.idbilanr = :idBilanR')
        ->setParameter('idBilanR', $idBilanR)
        ->getQuery()
        ->getSingleScalarResult();
}
public function sumOfProductionCosts(int $idBilanR): float
{
    return $this->createQueryBuilder('br')
        ->select('SUM(br.semences + br.coutmainoeuvre + br.coutsplantations + br.coutinterventionmedicale) as productionCosts')
        ->where('br.idbilanr = :idBilanR')
        ->setParameter('idBilanR', $idBilanR)
        ->getQuery()
        ->getSingleScalarResult();
}
public function sumOfOperatingExpenses(int $idBilanR): float
    {
        return $this->createQueryBuilder('br')
            ->select('SUM(br.chargeselectricite + br.chargeentretien + br.chargeadministratives) as totalExploitationCharges')
            ->where('br.idbilanr = :idBilanR')
            ->setParameter('idBilanR', $idBilanR)
            ->getQuery()
            ->getSingleScalarResult();
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
