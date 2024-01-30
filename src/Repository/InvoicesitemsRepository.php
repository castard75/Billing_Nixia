<?php

namespace App\Repository;

use App\Entity\Invoicesitems;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Invoicesitems>
 *
 * @method Invoicesitems|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoicesitems|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoicesitems[]    findAll()
 * @method Invoicesitems[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoicesitemsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoicesitems::class);
    }

//    /**
//     * @return Invoicesitems[] Returns an array of Invoicesitems objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Invoicesitems
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
