<?php

namespace App\Repository;

use App\Entity\Ouvrier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ouvrier>
 *
 * @method Ouvrier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ouvrier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ouvrier[]    findAll()
 * @method Ouvrier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OuvrierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ouvrier::class);
    }

    // Add your custom repository methods here, if needed

    // For example, a custom query to find ouvriers by a specific criteria
    // public function findByCustomCriteria($criteria): array
    // {
    //     return $this->createQueryBuilder('o')
    //         ->andWhere('o.someField = :val')
    //         ->setParameter('val', $criteria)
    //         ->orderBy('o.id', 'ASC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
}
