<?php

namespace App\Repository;

use App\Entity\Annee;
use App\Entity\Diplome;
use App\Entity\Etudiant;
use App\Entity\Semestre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Etudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etudiant[]    findAll()
 * @method Etudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtudiantRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Etudiant::class);
    }

    /**
     * @param $getId
     * @param $filters
     * @param $start
     * @param $length
     *
     * @return array
     */
    public function getArrayEtudiantsByFormation($getId, $filters, $start, $length): array
    {
        $etudiants = $this->getEtudiantsByFormation($getId, $filters, $start, $length);
        $tab = array();
        /** @var Etudiant $etudiant */
        foreach ($etudiants as $etudiant) {

            $t = array();

            $t['numetudiant'] = $etudiant->getId();
            $t['nom'] = $etudiant->getNom();
            $t['prenom'] = $etudiant->getPrenom();
            $t['semestre'] = $etudiant->getSemestre()->getLibelle();
            $t['profil'] = '';

            $tab[] = $t;
        }

        return $tab;
    }

    /**
     * @param      $formation
     * @param      $data
     * @param int  $page
     * @param null $max
     * @param bool $getResult
     *
     * @return \Doctrine\ORM\Query|mixed
     */
    public function getEtudiantsByFormation($formation, $data, $page = 0, $max = null, $getResult = true)
    {
        $qb = $this->_em->createQueryBuilder();
        $query = isset($data['query']) && $data['query'] ? $data['query'] : null;
        //$order = isset($data['query']) && $data['query'] ? $data['query'] : null;

        $qb
            ->select('u')
            ->from(Etudiant::class, 'u')
            ->innerJoin(Semestre::class, 's', 'WITH', 'u.semestre = s.id')
            ->innerJoin(Annee::class, 'a', 'WITH', 's.annee = a.id')
            ->innerJoin(Diplome::class, 'd', 'WITH', 'a.diplome = d.id')
            ->where('d.formation = :formation')
           // ->andWhere('u.visible = :visible')
           // ->andWhere('u.anneesortie = :anneesortie')
            ->setParameters(array('formation' => $formation));

        /*switch ($order[0]['column']) {
            case 0:
                //todo: mettre les tris.
                break;
        }*/

        if ($query) {
            $qb
                ->andWhere('u.nom like :query')
                ->orWhere('u.prenom like :query')
                ->setParameter('query', '%' . $query . '%');
        }

        if ($max) {
            $preparedQuery = $qb->getQuery()
                ->setMaxResults($max)
                ->setFirstResult($page * $max);
        } else {
            $preparedQuery = $qb->getQuery();
        }

        return $getResult ? $preparedQuery->getResult() : $preparedQuery;
    }

    /**
     * @param $semestre
     *
     * @return ArrayCollection
     */
    public function findBySemestre($semestre): ArrayCollection
    {
        return $this->createQueryBuilder('e')
            ->where('e.semestre = :semestre')
            ->setParameter('semestre', $semestre)
            ->orderBy('e.nom', 'ASC')
            ->orderBy('e.prenom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $slug
     */
    public function findOneBySlug($slug)
    {
    }
}
