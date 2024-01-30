<?php

namespace App\Repository;

use App\Entity\LinkContractInvoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LinkContractInvoice>
 *
 * @method LinkContractInvoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkContractInvoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkContractInvoice[]    findAll()
 * @method LinkContractInvoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkContractInvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkContractInvoice::class);
    }

//    /**
//     * @return LinkContractInvoice[] Returns an array of LinkContractInvoice objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LinkContractInvoice
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
