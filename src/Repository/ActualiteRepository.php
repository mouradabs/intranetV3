<?php

namespace App\Repository;

use App\Entity\Actualite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Actualite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actualite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actualite[]    findAll()
 * @method Actualite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActualiteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Actualite::class);
    }

    public function findByFormation($formation, $nbResult)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.formation = :formation')
            ->setParameter('formation', $formation)
            ->orderBy('a.created', 'DESC')
            ->setMaxResults($nbResult)
            ->getQuery()
            ->getResult();
    }
}
