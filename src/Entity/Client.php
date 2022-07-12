<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]

#[ApiResource(

    collectionOperations:[
        
        'post' => [

            'method'=>'post',

            'denormalization_context'=>['groups' => ['client:write']],

            //'normalization_context'=>['groups' => ['client:read:simple']]
        ],
        
        'get'=>[

            'method'=>'get',

            'normalization_context'=>['groups' => ['client:read:simple']]

        ]
    ],
    itemOperations:['put','get']

)]
class Client extends User
{
    
   
   
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('client:write,client:read:simple')]
    private $adresse;

    #[Groups('client:write,client:read:simple')]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephone;
    #[Groups('client:write')]

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    private $commandes;
   
    public function __construct()
    {
        $this->setRoles(["ROLE_CLIENT"]);
        $this->commandes = new ArrayCollection();
    }
    
    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

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
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }
}
