<?php

namespace App\Entity;

use App\Repository\FourgonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=FourgonRepository::class)
 
 */
class Fourgon
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_matriculation;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="fourgon")
     */
    private $Transaction_fourgon;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Matricule;

    public function __construct()
    {
        $this->Transaction_fourgon = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMatriculation(): ?\DateTimeInterface
    {
        return $this->date_matriculation;
    }

    public function setDateMatriculation(\DateTimeInterface $date_matriculation): self
    {
        $this->date_matriculation = $date_matriculation;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }


    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactionFourgon(): Collection
    {
        return $this->Transaction_fourgon;
    }

    public function addTransactionFourgon(Transaction $transactionFourgon): self
    {
        if (!$this->Transaction_fourgon->contains($transactionFourgon)) {
            $this->Transaction_fourgon[] = $transactionFourgon;
            $transactionFourgon->setFourgon($this);
        }

        return $this;
    }

    public function removeTransactionFourgon(Transaction $transactionFourgon): self
    {
        if ($this->Transaction_fourgon->removeElement($transactionFourgon)) {
            // set the owning side to null (unless already changed)
            if ($transactionFourgon->getFourgon() === $this) {
                $transactionFourgon->setFourgon(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return  $this->Matricule;
    }

    public function getMatricule(): ?string
    {
        return $this->Matricule;
    }

    public function setMatricule(string $Matricule): self
    {
        $this->Matricule = $Matricule;

        return $this;
    }
}
