<?php

namespace App\Entity;

use App\Repository\ParkingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParkingRepository::class)
 */
class Parking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $AdressParking;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Capacite;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Couvre_Soleil;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Mail;

    /**
     * @ORM\Column(type="integer")
     */
    private $Tele;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="Parking_matricule")
     */
    private $Transaction_parking;

    public function __construct()
    {
        $this->Transaction_parking = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdressParking(): ?string
    {
        return $this->AdressParking;
    }

    public function setAdressParking(string $AdressParking): self
    {
        $this->AdressParking = $AdressParking;

        return $this;
    }

    public function getCapacite(): ?string
    {
        return $this->Capacite;
    }

    public function setCapacite(string $Capacite): self
    {
        $this->Capacite = $Capacite;

        return $this;
    }

    public function getCouvreSoleil(): ?string
    {
        return $this->Couvre_Soleil;
    }

    public function setCouvreSoleil(string $Couvre_Soleil): self
    {
        $this->Couvre_Soleil = $Couvre_Soleil;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(string $Mail): self
    {
        $this->Mail = $Mail;

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
    public function getTransactionParking(): Collection
    {
        return $this->Transaction_parking;
    }

    public function addTransactionParking(Transaction $transactionParking): self
    {
        if (!$this->Transaction_parking->contains($transactionParking)) {
            $this->Transaction_parking[] = $transactionParking;
            $transactionParking->setParkingMatricule($this);
        }

        return $this;
    }

    public function removeTransactionParking(Transaction $transactionParking): self
    {
        if ($this->Transaction_parking->removeElement($transactionParking)) {
            // set the owning side to null (unless already changed)
            if ($transactionParking->getParkingMatricule() === $this) {
                $transactionParking->setParkingMatricule(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return  $this->AdressParking;
    }
}
