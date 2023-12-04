<?php

namespace App\Repository;

use App\Entity\Traitementmedicale;
use App\Entity\Veterinaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Veterinaire>
 *
 * @method Veterinaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Veterinaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Veterinaire[]    findAll()
 * @method Veterinaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VeterinaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Veterinaire::class);
    }


    public function remove(Veterinaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //METIERRRRRRR :
    public function isVeterinaireInUse(Veterinaire $veterinaire): bool
    {
        return $this->_em->getRepository(Traitementmedicale::class)->findOneBy(['idvet' => $veterinaire]) !== null;
    }

//    /**
//     * @return Veterinaire[] Returns an array of Veterinaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Veterinaire
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }




public function searchByNomPrenomAdresse($query)
    {
        return $this->createQueryBuilder('v')
            ->where('v.nomvet LIKE :query OR v.prenomvet LIKE :query OR v.adresscabinet LIKE :query')
            ->setParameter('query', "%{$query}%")
            ->getQuery()
            ->getResult();
    }
    public function countVeterinairesParVille()
    {
        return $this->createQueryBuilder('v')
            ->select('SUBSTRING(v.adresscabinet, 1, LOCATE(\':\', v.adresscabinet) - 1) as ville', 'COUNT(v.idvet) as count')
            ->groupBy('ville')
            ->getQuery()
            ->getResult();
    }

    // VeterinaireRepository.php

    public function searchByTerm(string $term)
    {
        return $this->createQueryBuilder('v')
            ->where('v.nomvet LIKE :term OR v.prenomvet LIKE :term OR v.adresscabinet LIKE :term')
            ->setParameter('term', '%' . $term . '%')
            ->getQuery()
            ->getResult();
    }
}
