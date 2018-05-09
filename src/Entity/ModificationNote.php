<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModificationNoteRepository")
 */
class ModificationNote extends BaseEntity
{


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Note", inversedBy="modificationNotes")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Personnel", inversedBy="modificationNotes")
     */
    private $personnel;

    /**
     * @ORM\Column(type="float")
     */
    private $ancienne_note;

    /**
     * @ORM\Column(type="float")
     */
    private $nouvelle_note;

    public function getNote(): ?Note
    {
        return $this->note;
    }

    public function setNote(?Note $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getPersonnel(): ?Personnel
    {
        return $this->personnel;
    }

    public function setPersonnel(?Personnel $personnel): self
    {
        $this->personnel = $personnel;

        return $this;
    }

    public function getAncienneNote(): ?float
    {
        return $this->ancienne_note;
    }

    public function setAncienneNote(float $ancienne_note): self
    {
        $this->ancienne_note = $ancienne_note;

        return $this;
    }

    public function getNouvelleNote(): ?float
    {
        return $this->nouvelle_note;
    }

    public function setNouvelleNote(float $nouvelle_note): self
    {
        $this->nouvelle_note = $nouvelle_note;

        return $this;
    }
}
