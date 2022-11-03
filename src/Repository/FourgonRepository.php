<?php

namespace App\Repository;

use App\Entity\Fourgon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fourgon>
 *
 * @method Fourgon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fourgon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fourgon[]    findAll()
 * @method Fourgon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FourgonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fourgon::class);
    }

    public function add(Fourgon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fourgon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
     * @return int|mixed|string|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function countAllFourgon()
    {
        $queryBuilder = $this->createQueryBuilder('b');
        $queryBuilder->select('COUNT(b.id) as value');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    //    /**
    //     * @return Fourgon[] Returns an array of Fourgon objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Fourgon
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
