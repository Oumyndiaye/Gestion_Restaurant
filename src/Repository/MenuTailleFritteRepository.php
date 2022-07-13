<?php

namespace App\Repository;

use App\Entity\MenuTailleFritte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MenuTailleFritte>
 *
 * @method MenuTailleFritte|null find($id, $lockMode = null, $lockVersion = null)
 * @method MenuTailleFritte|null findOneBy(array $criteria, array $orderBy = null)
 * @method MenuTailleFritte[]    findAll()
 * @method MenuTailleFritte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MenuTailleFritteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MenuTailleFritte::class);
    }

    public function add(MenuTailleFritte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MenuTailleFritte $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MenuTailleFritte[] Returns an array of MenuTailleFritte objects
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

//    public function findOneBySomeField($value): ?MenuTailleFritte
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
