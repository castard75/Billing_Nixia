<?php

namespace App\Repository;

use App\Entity\IndicatifSda;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IndicatifSda>
 *
 * @method IndicatifSda|null find($id, $lockMode = null, $lockVersion = null)
 * @method IndicatifSda|null findOneBy(array $criteria, array $orderBy = null)
 * @method IndicatifSda[]    findAll()
 * @method IndicatifSda[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndicatifSdaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IndicatifSda::class);
    }

//    /**
//     * @return IndicatifSda[] Returns an array of IndicatifSda objects
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

//    public function findOneBySomeField($value): ?IndicatifSda
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
