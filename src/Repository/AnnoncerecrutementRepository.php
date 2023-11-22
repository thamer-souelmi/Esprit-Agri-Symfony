<?php

namespace App\Repository;

use App\Entity\Annoncerecrutement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function searchByPosteContratLoca($query)    { 
        

        return $this->createQueryBuilder('AR')        
            ->where('AR.postedemande LIKE :query OR AR.typecontrat LIKE :query OR AR.localisation LIKE :query')   
                     ->setParameter('query', "%{$query}%")        
                         ->getQuery()         
                            ->getResult();    }

    
    
                            
                            public function isAnnReInUse(Annoncerecrutement $annoncerecrutement): bool
                            {
                                return $this->_em->getRepository(Annoncerecrutement::class)->findOneBy(['annoncerecrutement' => $annoncerecrutement]) !== null;
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
}
