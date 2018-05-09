<?php

namespace App\Repository;

use App\Entity\Hrs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Hrs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hrs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hrs[]    findAll()
 * @method Hrs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HrsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hrs::class);
    }

    public function findHrsEnseignant($getUser, $annee)
    {
        return $this->createQueryBuilder('h')
            ->where('h.personnel = :user')
            ->andWhere('h.annee = :annee')
            ->setParameter('user', $getUser)
            ->setParameter('annee', $annee)
            ->orderBy('h.typeHrs', 'ASC')
            ->orderBy('h.semestre', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Hrs[] Returns an array of Hrs objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hrs
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
