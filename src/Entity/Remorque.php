<?php

namespace App\Entity;

use App\Repository\RemorqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=RemorqueRepository::class)
 */
class Remorque
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
    private $Date_mservice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;



    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="Remorque")
     */
    private $Transaction_remorque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Matri;

    public function __construct()
    {
        $this->Transaction_remorque = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMservice(): ?\DateTimeInterface
    {
        return $this->Date_mservice;
    }

    public function setDateMservice(\DateTimeInterface $Date_mservice): self
    {
        $this->Date_mservice = $Date_mservice;

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
    public function getTransactionRemorque(): Collection
    {
        return $this->Transaction_remorque;
    }

    public function addTransactionRemorque(Transaction $transactionRemorque): self
    {
        if (!$this->Transaction_remorque->contains($transactionRemorque)) {
            $this->Transaction_remorque[] = $transactionRemorque;
            $transactionRemorque->setRemorque($this);
        }

        return $this;
    }

    public function removeTransactionRemorque(Transaction $transactionRemorque): self
    {
        if ($this->Transaction_remorque->removeElement($transactionRemorque)) {
            // set the owning side to null (unless already changed)
            if ($transactionRemorque->getRemorque() === $this) {
                $transactionRemorque->setRemorque(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return  $this->Matri;
    }

    public function getMatri(): ?string
    {
        return $this->Matri;
    }

    public function setMatri(string $Matri): self
    {
        $this->Matri = $Matri;

        return $this;
    }
}
