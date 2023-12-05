<?php

namespace App\Repository;

use App\Entity\Bilancomptable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;


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
    public function sumOfValues(int $idBilanC): float
{
    return $this->createQueryBuilder('b')
        ->select('SUM(b.valeurterrain + b.materiels + b.autresimmobilisations) as totalActifImmobilise')
        ->where('b.idbilanc = :idBilanC')
        ->setParameter('idBilanC', $idBilanC)
        ->getQuery()
        ->getResult(Query::HYDRATE_SINGLE_SCALAR);
}
public function sumOfTotalActifCirculant(int $idBilanC): float
{
    return $this->createQueryBuilder('b')
        ->select('SUM(b.stocksproduits + b.creanceclient + b.tresorie) as totalActifCirculant')
        ->where('b.idbilanc = :idBilanC')
        ->setParameter('idBilanC', $idBilanC)
        ->getQuery()
        ->getResult(Query::HYDRATE_SINGLE_SCALAR);
}
public function sumOfTotalCapitauxPropres(int $idBilanC): float
{
    return $this->createQueryBuilder('b')
        ->select('SUM(b.capitalsocial + b.reserves + b.resultatnet) as totalCapitauxPropres')
        ->where('b.idbilanc = :idBilanC')
        ->setParameter('idBilanC', $idBilanC)
        ->getQuery()
        ->getResult(Query::HYDRATE_SINGLE_SCALAR);
}
public function sumOfTotalDettesLongTerme(int $idBilanC): float
{
    return $this->createQueryBuilder('b')
        ->select('SUM(b.emprunts + b.dettesit) as totalDettesLongTerme')
        ->where('b.idbilanc = :idBilanC')
        ->setParameter('idBilanC', $idBilanC)
        ->getQuery()
        ->getResult(Query::HYDRATE_SINGLE_SCALAR);
}
public function sumOfTotalDettesCourtTerme(int $idBilanC): float
{
    return $this->createQueryBuilder('b')
        ->select('SUM(b.fournisseurs + b.dettesct) as totalDettesCourtTerme')
        ->where('b.idbilanc = :idBilanC')
        ->setParameter('idBilanC', $idBilanC)
        ->getQuery()
        ->getResult(Query::HYDRATE_SINGLE_SCALAR);
}
public function findByIdbilanc(int $idbilanc): ?Bilancomptable
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.idbilanc = :idbilanc')
            ->setParameter('idbilanc', $idbilanc)
            ->getQuery()
            ->getOneOrNullResult();
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
