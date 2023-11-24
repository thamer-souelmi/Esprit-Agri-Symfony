<?php

namespace App\Repository;

use App\Entity\Culture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Culture>
 *
 * @method Culture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Culture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Culture[]    findAll()
 * @method Culture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CultureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Culture::class);
    }

    public function save(Culture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Culture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Example of a custom query method to find entities by string
    public function findEntitiesByString($str)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT c FROM App\Entity\Culture c
            WHERE c.libelle LIKE :str or c.categorytype LIKE :str'
        );

        $query->setParameter('str', '%' . $str . '%');

        return $query->getResult();
    }
}
