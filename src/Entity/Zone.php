<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["collection_get:zone"]]
        ],
        "post" =>
        [
            "method" => "post",
            "denormalization_context" => ["groups" => ["collection:zone_post:write"]],
            "normalization_context" => ["groups" => ["collection:zone_post:read"]]

        ]
    ],
    itemOperations: [
        'get' =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["item:zone_get:read"]]
        ],"put"=>[
            "method" => "put",
            "denormalization_context" => ["groups" => ["item:zone_put:write"]],
            "normalization_context" => ["groups" => ["item:zone_put:read"]]

        ]
    ]

)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(
        "collection_get:zone","collection:zone_post:write",
        "collection:zone_post:read","item:zone_get:read",
        "item:zone_put:write"
    )]
    private $id;
   
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups("collection_get:zone","collection:zone_post:write",
    "collection:zone_post:read","item:zone_get:read",
    "item:zone_put:write")]
    private $nom_zone;
    #[Groups("collection_get:zone","collection:zone_post:write",
    "collection:zone_post:read","item:zone_get:read",
    "item:zone_put:write")]

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prix_zone;
    #[Groups("collection_get:zone","collection:zone_post:write",
    "collection:zone_post:read","item:zone_get:read",
    "item:zone_put:write")]

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    private $quartiers;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
    private $commandes;

    public function __construct()
    {
        $this->quartiers = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomZone(): ?string
    {
        return $this->nom_zone;
    }

    public function setNomZone(?string $nom_zone): self
    {
        $this->nom_zone = $nom_zone;

        return $this;
    }

    public function getPrixZone(): ?string
    {
        return $this->prix_zone;
    }

    public function setPrixZone(?string $prix_zone): self
    {
        $this->prix_zone = $prix_zone;

        return $this;
    }

    /**
     * @return Collection<int, Quartier>
     */
    public function getQuartiers(): Collection
    {
        return $this->quartiers;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartiers->contains($quartier)) {
            $this->quartiers[] = $quartier;
            $quartier->setZone($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartiers->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getZone() === $this) {
                $quartier->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getZone() === $this) {
                $commande->setZone(null);
            }
        }

        return $this;
    }
}
