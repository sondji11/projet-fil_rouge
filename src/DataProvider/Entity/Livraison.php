<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\OpenApi\Model\Operation;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "method"=>"get",
        "normalization_context"=>["groups"=>["livraison:read:simple"]]
    ],
    "post"=>[
        "method"=>"post",
        "denormalization_context"=>["groups"=>["livraison:write:simple"]]
        
    ]],
    itemOperations:[
        "get","put"
    ],

)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("livraison:write:simple")]
    private $id;
    #[Groups("livraison:write:simple")]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $montant_total;
    // #[Groups("livraison:write:simple")]
    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    private $commandes;
    #[Groups("livraison:write:simple")]
    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    private $livreur;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantTotal(): ?string
    {
        return $this->montant_total;
    }

    public function setMontantTotal(?string $montant_total): self
    {
        $this->montant_total = $montant_total;

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
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }
}
