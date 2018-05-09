<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonnelRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Personnel extends Utilisateur // implements SerializerInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     *
     */
    protected $statut;

    /**
     * @ORM\Column(type="string", length=10,nullable=true)
     *
     */
    protected $poste_interne;

    /**
     * @ORM\Column(type="string", length=20,nullable=true)
     *
     */
    protected $tel_bureau;

    /**
     * @ORM\Column(type="text",nullable=true)
     *
     */
    protected $responsabilites;

    /**
     * @ORM\Column(type="text",nullable=true)
     *
     */
    protected $domaines;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     */
    protected $entreprise;

    /**
     * @ORM\Column(type="string", length=20,nullable=true)
     *
     */
    protected $bureau1;

    /**
     * @ORM\Column(type="string", length=20,nullable=true)
     *
     */
    protected $bureau2;

    /**
     * @ORM\Column(type="integer",nullable=true)
     *
     */
    protected $numero_harpege;

    /**
     * @ORM\Column(type="string",length=10,nullable=true)
     *
     */
    protected $initiales;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     *
     */
    protected $cv;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hrs", mappedBy="personnel")
     */
    private $hrs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Previsionnel", mappedBy="personnel")
     */
    private $previsionnels;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Evaluation", mappedBy="personnel_auteur")
     */
    private $evaluations_auteur;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Evaluation", mappedBy="personnel_autorise")
     */
    private $evaluations_autorise;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ModificationNote", mappedBy="personnel")
     */
    private $modificationNotes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PersonnelFormation", mappedBy="personnel")
     */
    private $personnelFormations;

    /**
     * @ORM\Column(type="float")
     */
    private $nbHeuresService;



    public function __construct()
    {
        $this->hrs = new ArrayCollection();
        $this->previsionnels = new ArrayCollection();
        $this->evaluations_auteur = new ArrayCollection();
        $this->evaluations_autorise = new ArrayCollection();
        $this->modificationNotes = new ArrayCollection();
        //$this->personnelFormations = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }



    /**
     * @return mixed
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * @param mixed $statut
     */
    public function setStatut($statut): void
    {
        $this->statut = $statut;
    }

    /**
     * @return mixed
     */
    public function getPosteInterne()
    {
        return $this->poste_interne;
    }

    /**
     * @param mixed $poste_interne
     */
    public function setPosteInterne($poste_interne): void
    {
        $this->poste_interne = $poste_interne;
    }

    /**
     * @return mixed
     */
    public function getTelBureau()
    {
        return $this->tel_bureau;
    }

    /**
     * @param mixed $tel_bureau
     */
    public function setTelBureau($tel_bureau): void
    {
        $this->tel_bureau = $tel_bureau;
    }

    /**
     * @return mixed
     */
    public function getResponsabilites()
    {
        return $this->responsabilites;
    }

    /**
     * @param mixed $responsabilites
     */
    public function setResponsabilites($responsabilites): void
    {
        $this->responsabilites = $responsabilites;
    }

    /**
     * @return mixed
     */
    public function getDomaines()
    {
        return $this->domaines;
    }

    /**
     * @param mixed $domaines
     */
    public function setDomaines($domaines): void
    {
        $this->domaines = $domaines;
    }

    /**
     * @return mixed
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * @param mixed $entreprise
     */
    public function setEntreprise($entreprise): void
    {
        $this->entreprise = $entreprise;
    }

    /**
     * @return mixed
     */
    public function getBureau1()
    {
        return $this->bureau1;
    }

    /**
     * @param mixed $bureau1
     */
    public function setBureau1($bureau1): void
    {
        $this->bureau1 = $bureau1;
    }

    /**
     * @return mixed
     */
    public function getBureau2()
    {
        return $this->bureau2;
    }

    /**
     * @param mixed $bureau2
     */
    public function setBureau2($bureau2): void
    {
        $this->bureau2 = $bureau2;
    }

    /**
     * @return mixed
     */
    public function getNumeroHarpege()
    {
        return $this->numero_harpege;
    }

    /**
     * @param mixed $numero_harpege
     */
    public function setNumeroHarpege($numero_harpege): void
    {
        $this->numero_harpege = $numero_harpege;
    }

    /**
     * @return mixed
     */
    public function getInitiales()
    {
        return $this->initiales;
    }

    /**
     * @param mixed $initiales
     */
    public function setInitiales($initiales): void
    {
        $this->initiales = $initiales;
    }

    /**
     * @return mixed
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * @param mixed $cv
     */
    public function setCv($cv): void
    {
        $this->cv = $cv;
    }

    /**
     * @return Collection|Hrs[]
     */
    public function getHrs(): Collection
    {
        return $this->hrs;
    }

    public function addHr(Hrs $hr): self
    {
        if (!$this->hrs->contains($hr)) {
            $this->hrs[] = $hr;
            $hr->setPersonnel($this);
        }

        return $this;
    }

    public function removeHr(Hrs $hr): self
    {
        if ($this->hrs->contains($hr)) {
            $this->hrs->removeElement($hr);
            // set the owning side to null (unless already changed)
            if ($hr->getPersonnel() === $this) {
                $hr->setPersonnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Previsionnel[]
     */
    public function getPrevisionnels(): Collection
    {
        return $this->previsionnels;
    }

    public function addPrevisionnel(Previsionnel $previsionnel): self
    {
        if (!$this->previsionnels->contains($previsionnel)) {
            $this->previsionnels[] = $previsionnel;
            $previsionnel->setPersonnel($this);
        }

        return $this;
    }

    public function removePrevisionnel(Previsionnel $previsionnel): self
    {
        if ($this->previsionnels->contains($previsionnel)) {
            $this->previsionnels->removeElement($previsionnel);
            // set the owning side to null (unless already changed)
            if ($previsionnel->getPersonnel() === $this) {
                $previsionnel->setPersonnel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evaluation[]
     */
    public function getEvaluationsAuteur(): Collection
    {
        return $this->evaluations_auteur;
    }

    public function addEvaluationsAuteur(Evaluation $evaluationsAuteur): self
    {
        if (!$this->evaluations_auteur->contains($evaluationsAuteur)) {
            $this->evaluations_auteur[] = $evaluationsAuteur;
            $evaluationsAuteur->setPersonnelAuteur($this);
        }

        return $this;
    }

    public function removeEvaluationsAuteur(Evaluation $evaluationsAuteur): self
    {
        if ($this->evaluations_auteur->contains($evaluationsAuteur)) {
            $this->evaluations_auteur->removeElement($evaluationsAuteur);
            // set the owning side to null (unless already changed)
            if ($evaluationsAuteur->getPersonnelAuteur() === $this) {
                $evaluationsAuteur->setPersonnelAuteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Evaluation[]
     */
    public function getEvaluationsAutorise(): Collection
    {
        return $this->evaluations_autorise;
    }

    public function addEvaluationsAutorise(Evaluation $evaluationsAutorise): self
    {
        if (!$this->evaluations_autorise->contains($evaluationsAutorise)) {
            $this->evaluations_autorise[] = $evaluationsAutorise;
            $evaluationsAutorise->addPersonnelAutorise($this);
        }

        return $this;
    }

    public function removeEvaluationsAutorise(Evaluation $evaluationsAutorise): self
    {
        if ($this->evaluations_autorise->contains($evaluationsAutorise)) {
            $this->evaluations_autorise->removeElement($evaluationsAutorise);
            $evaluationsAutorise->removePersonnelAutorise($this);
        }

        return $this;
    }

    /**
     * @return Collection|ModificationNote[]
     */
    public function getModificationNotes(): Collection
    {
        return $this->modificationNotes;
    }

    public function addModificationNote(ModificationNote $modificationNote): self
    {
        if (!$this->modificationNotes->contains($modificationNote)) {
            $this->modificationNotes[] = $modificationNote;
            $modificationNote->setPersonnel($this);
        }

        return $this;
    }

    public function removeModificationNote(ModificationNote $modificationNote): self
    {
        if ($this->modificationNotes->contains($modificationNote)) {
            $this->modificationNotes->removeElement($modificationNote);
            // set the owning side to null (unless already changed)
            if ($modificationNote->getPersonnel() === $this) {
                $modificationNote->setPersonnel(null);
            }
        }

        return $this;
    }

    public function getNbHeuresService(): ?float
    {
        return $this->nbHeuresService;
    }

    public function setNbHeuresService(float $nbHeuresService): self
    {
        $this->nbHeuresService = $nbHeuresService;

        return $this;
    }

//    /**
//     * @return Collection|PersonnelFormation[]
//     */
//    public function getPersonnelFormations(): Collection
//    {
//        return $this->personnelFormations;
//    }
//
//    public function addPersonnelFormation(PersonnelFormation $personnelFormation): self
//    {
//        if (!$this->personnelFormations->contains($personnelFormation)) {
//            $this->personnelFormations[] = $personnelFormation;
//            $personnelFormation->setPersonnel($this);
//        }
//
//        return $this;
//    }
//
//    public function removePersonnelFormation(PersonnelFormation $personnelFormation): self
//    {
//        if ($this->personnelFormations->contains($personnelFormation)) {
//            $this->personnelFormations->removeElement($personnelFormation);
//            // set the owning side to null (unless already changed)
//            if ($personnelFormation->getPersonnel() === $this) {
//                $personnelFormation->setPersonnel(null);
//            }
//        }
//
//        return $this;
//    }
}
