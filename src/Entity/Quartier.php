<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\QuartierRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            "method"=>"get",
            "normalization_context"=>["groups"=>["collection:quartier_get:read"]]
        ],
        "post"=>[
            
                "method"=>"post",
                "denormalization_context"=>["groups"=>["collection:quartier_post:write"]],
                "normalization_context"=>["groups"=>["collection:quartier_post:read"]]

                  ]
         ],
    itemOperations:["get"=>
    [
        "method"=>"get",
        "normalization_context"=>["groups"=>["item:quartier_get:read"]]
    ],
    "put"=>[
        "method"=>"put",
        "denormalization_context"=>["groups"=>["item:quartier_put:write"]],
        "normalization_context"=>["groups"=>["item:quartier_put:read"]]

        ]
    ]
)]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(
        "collection:quartier_post:write","collection:quartier_post:read",
        "collection:quartier_get:read","item:quartier_get:read",
        "item:quartier_put:write","item:quartier_put:read"

    )]

    private $id;
   
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(
        "collection:quartier_post:write",
        "collection:quartier_post:read",

    )]  
      
    private $libelle_quartier;
    #[Groups(
        "collection:quartier_post:write"
        ,"collection:quartier_post:read",
     )]
    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]
    private $zone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleQuartier(): ?string
    {
        return $this->libelle_quartier;
    }

    public function setLibelleQuartier(?string $libelle_quartier): self
    {
        $this->libelle_quartier = $libelle_quartier;

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
}
