<?php

namespace App\Repository;

use App\Entity\EngagementPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EngagementPost>
 *
 * @method EngagementPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method EngagementPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method EngagementPost[]    findAll()
 * @method EngagementPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EngagementPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EngagementPost::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(EngagementPost $entity, bool $flush = true): void
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
    public function remove(EngagementPost $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return EngagementPost[] Returns an array of EngagementPost objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EngagementPost
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
