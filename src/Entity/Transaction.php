<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
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
    private $Date_transit;

    /**
     * @ORM\Column(type="integer")
     */
    private $Montant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Num_dossier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Num_facture;

    /**
     * @ORM\ManyToOne(targetEntity=Agent::class, inversedBy="Transaction")
     */
    private $Agent_matricule;

    /**
     * @ORM\ManyToOne(targetEntity=Fournisseur::class, inversedBy="Transaction_fournisseur")
     */
    private $Fournisseur_matri;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="Client_transaction")
     */
    private $Client;

    /**
     * @ORM\ManyToOne(targetEntity=Fourgon::class, inversedBy="Transaction_fourgon")
     */
    private $fourgon;

    /**
     * @ORM\ManyToOne(targetEntity=Remorque::class, inversedBy="Transaction_remorque")
     */
    private $Remorque;

    /**
     * @ORM\ManyToOne(targetEntity=Parking::class, inversedBy="Transaction_parking")
     */
    private $Parking_matricule;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTransit(): ?\DateTimeInterface
    {
        return $this->Date_transit;
    }

    public function setDateTransit(\DateTimeInterface $Date_transit): self
    {
        $this->Date_transit = $Date_transit;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->Montant;
    }

    public function setMontant(int $Montant): self
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getNumDossier(): ?string
    {
        return $this->Num_dossier;
    }

    public function setNumDossier(string $Num_dossier): self
    {
        $this->Num_dossier = $Num_dossier;

        return $this;
    }

    public function getNumFacture(): ?string
    {
        return $this->Num_facture;
    }

    public function setNumFacture(string $Num_facture): self
    {
        $this->Num_facture = $Num_facture;

        return $this;
    }

    public function getAgentMatricule(): ?Agent
    {
        return $this->Agent_matricule;
    }

    public function setAgentMatricule(?Agent $Agent_matricule): self
    {
        $this->Agent_matricule = $Agent_matricule;

        return $this;
    }

    public function getFournisseurMatri(): ?Fournisseur
    {
        return $this->Fournisseur_matri;
    }

    public function setFournisseurMatri(?Fournisseur $Fournisseur_matri): self
    {
        $this->Fournisseur_matri = $Fournisseur_matri;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public function getFourgon(): ?Fourgon
    {
        return $this->fourgon;
    }

    public function setFourgon(?Fourgon $fourgon): self
    {
        $this->fourgon = $fourgon;

        return $this;
    }

    public function getRemorque(): ?Remorque
    {
        return $this->Remorque;
    }

    public function setRemorque(?Remorque $Remorque): self
    {
        $this->Remorque = $Remorque;

        return $this;
    }

    public function getParkingMatricule(): ?Parking
    {
        return $this->Parking_matricule;
    }

    public function setParkingMatricule(?Parking $Parking_matricule): self
    {
        $this->Parking_matricule = $Parking_matricule;

        return $this;
    }
}
