<?php

namespace App\Repository;

use App\Entity\PriceProposalFeature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PriceProposalFeature>
 *
 * @method PriceProposalFeature|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceProposalFeature|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceProposalFeature[]    findAll()
 * @method PriceProposalFeature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceProposalFeatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriceProposalFeature::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PriceProposalFeature $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PriceProposalFeature $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return PriceProposalFeature[] Returns an array of PriceProposalFeature objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PriceProposalFeature
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
