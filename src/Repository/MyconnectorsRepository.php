<?php

namespace App\Repository;

use App\Entity\Myconnectors;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Myconnectors>
 *
 * @method Myconnectors|null find($id, $lockMode = null, $lockVersion = null)
 * @method Myconnectors|null findOneBy(array $criteria, array $orderBy = null)
 * @method Myconnectors[]    findAll()
 * @method Myconnectors[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyconnectorsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Myconnectors::class);
    }

//    /**
//     * @return Myconnectors[] Returns an array of Myconnectors objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Myconnectors
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
