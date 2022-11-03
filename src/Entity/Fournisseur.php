<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FournisseurRepository::class)
 */
class Fournisseur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $Tel;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="Fournisseur_matri")
     */
    private $Transaction_fournisseur;

    public function __construct()
    {
        $this->Transaction_fournisseur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdress(): ?string
    {
        return $this->Adress;
    }

    public function setAdress(string $Adress): self
    {
        $this->Adress = $Adress;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->Tel;
    }

    public function setTel(int $Tel): self
    {
        $this->Tel = $Tel;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransactionFournisseur(): Collection
    {
        return $this->Transaction_fournisseur;
    }

    public function addTransactionFournisseur(Transaction $transactionFournisseur): self
    {
        if (!$this->Transaction_fournisseur->contains($transactionFournisseur)) {
            $this->Transaction_fournisseur[] = $transactionFournisseur;
            $transactionFournisseur->setFournisseurMatri($this);
        }

        return $this;
    }

    public function removeTransactionFournisseur(Transaction $transactionFournisseur): self
    {
        if ($this->Transaction_fournisseur->removeElement($transactionFournisseur)) {
            // set the owning side to null (unless already changed)
            if ($transactionFournisseur->getFournisseurMatri() === $this) {
                $transactionFournisseur->setFournisseurMatri(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return  $this->nom;
    }
}
