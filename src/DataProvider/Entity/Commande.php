<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "security" => "is_granted('ROLE_CLIENT')",
            "security_message" => "Veuillez vous connecter d'abord",
            "normalization_context" => ["groups" => ["commande:get:collection"]]
        ],
        "post" =>
        [
            "method" => "post",
            "normalization_context" => ["groups" => ["commande:read:post"]],
            "denormalization_context" => ["groups" => ["commande:write:post"]]
        ]

    ],
    itemOperations: [
        "get" =>
        [
            "method" => "get",
            "security" => "is_granted('ROLE_CLIENT')",
            "security_message" => "Veuillez vous connecter d'abord",
            "normalization_context" => ["groups" => ["commande:get:item"]]
        ],
        "put" =>
        [
            "method" => "put",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez aucun droit pour accéder à cette ressource",
            "normalization_context" => ["groups" => ["commande:read:put"]],
            "denormalization_context" => ["groups" => ["commande:write:put"]]
        ]
    ]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["post:livraison:read", "post:livraison:write"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numerocommande;

    #[ORM\Column(type: 'date', nullable: true)]
    private $date;

    #[ORM\Column(type: 'string', nullable: true)]
    private $etat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $montant;
    #[Groups('zone:write:simple')]
    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;
    #[Groups('client:write')]
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    private $client;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumerocommande(): ?string
    {
        return $this->numerocommande;
    }

    public function setNumerocommande(?string $numerocommande): self
    {
        $this->numerocommande = $numerocommande;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(?string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
