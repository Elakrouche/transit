<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentRepository::class)
 */
class Agent
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
     *@ORM\Column(type="integer")
     */
    private $Tele;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="Agent_matricule")
     */
    private $Transaction;

    public function __construct()
    {
        $this->Transaction = new ArrayCollection();
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

    public function getTele(): ?int
    {
        return $this->Tele;
    }

    public function setTele(int $Tele): self
    {
        $this->Tele = $Tele;

        return $this;
    }

    /**
     * @return Collection<int, Transaction>
     */
    public function getTransaction(): Collection
    {
        return $this->Transaction;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->Transaction->contains($transaction)) {
            $this->Transaction[] = $transaction;
            $transaction->setAgentMatricule($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->Transaction->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getAgentMatricule() === $this) {
                $transaction->setAgentMatricule(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return  $this->nom;
    }
}
