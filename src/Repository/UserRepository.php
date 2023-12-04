<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, User::class);
        $this->entityManager = $entityManager;
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findByRoles(string $role): array
{
    $qb = $this->createQueryBuilder('c')
        ->where('c.role != :role')
        ->setParameter('role', $role)
        ->getQuery();

    return $qb->getResult();
}
// public function findOneBynom($nom): ?User
//     {
//         return $this->createQueryBuilder('u')
//             ->andWhere('u.nom = :nom')
//             ->setParameter('nom', $nom)
//             ->getQuery()
//             ->getOneOrNullResult()
//         ;
//     }
public function getUsersWithMoreThanFiveReclamationsCount()
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('u.id, u.nom, COUNT(r.id) AS totalReclamations')
            ->from(User::class, 'u')
            ->join('u.products', 'p')
            ->join('p.reclamations', 'r')
            ->groupBy('u.id')
            ->having('COUNT(r.id) < 5')
            ->getQuery()
            ->getResult();
    }
}
