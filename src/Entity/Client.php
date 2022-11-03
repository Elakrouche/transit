<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
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
    private $Tele;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="Client")
     */
    private $Client_transaction;



    public function __construct()
    {
        $this->Client_transaction = new ArrayCollection();
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
    public function getClientTransaction(): Collection
    {
        return $this->Client_transaction;
    }

    public function addClientTransaction(Transaction $clientTransaction): self
    {
        if (!$this->Client_transaction->contains($clientTransaction)) {
            $this->Client_transaction[] = $clientTransaction;
            $clientTransaction->setClient($this);
        }

        return $this;
    }

    public function removeClientTransaction(Transaction $clientTransaction): self
    {
        if ($this->Client_transaction->removeElement($clientTransaction)) {
            // set the owning side to null (unless already changed)
            if ($clientTransaction->getClient() === $this) {
                $clientTransaction->setClient(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return  $this->nom;
    }
}
