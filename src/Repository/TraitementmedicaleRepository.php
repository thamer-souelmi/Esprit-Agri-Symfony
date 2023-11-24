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


}
