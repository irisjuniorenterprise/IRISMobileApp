<?php

namespace App\Repository;

use App\Entity\BiblioIRIS;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BiblioIRIS>
 *
 * @method BiblioIRIS|null find($id, $lockMode = null, $lockVersion = null)
 * @method BiblioIRIS|null findOneBy(array $criteria, array $orderBy = null)
 * @method BiblioIRIS[]    findAll()
 * @method BiblioIRIS[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BiblioIRISRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BiblioIRIS::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(BiblioIRIS $entity, bool $flush = true): void
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
    public function remove(BiblioIRIS $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return BiblioIRIS[] Returns an array of BiblioIRIS objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BiblioIRIS
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
