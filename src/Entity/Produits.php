<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]

#[ApiResource (
    collectionOperations:[
        "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['burgers:read:simple']],
        ],
        "post"=>[
        'method' => 'post',
        'denormalization_context' => ['groups' => ['write']],
        ]
        ],
        itemOperations:[
                        // "get"=>[
                        // 'method' => 'get',
                        // "path"=>"/bugers/{id}" ,
                        // 'requirements' => ['id' => '\d+'],
                        // 'normalization_context' => ['groups' => ['all']],
                        // ],
                        "put"=>[
                            "security" => "is_granted('ROLE_GESTIONNAIRE')",
                            "security_message"=>"Vous n'avez pas access à cette Ressource"
                           
                            ],
                    ]
            )]
    
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["produits"=>"Produits","menu"=>"Menu","burger"=>"Burger","boisson"=>"Boisson","portionfrite"=>"Portionfrite"])]

class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    // #[Groups(["djibril"])]
    #[Groups(["burgers:read:simple","menu:write" ,"write",'menu:frite','boisson:write','menu:read:simple','All'])]

    protected $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    // #[Groups(["djibril"])]
    #[Groups(['All',"burgers:read:simple",'menu:write','write','boisson:write','menu:read:simple','menu:frite'])]

    protected $nom;

    #[ORM\Column(type:'string', nullable: true)]
    #[Groups(['All',"burgers:read:simple",'menu:write' ,'write','menu:read:simple','menu:frite','boisson:write'])]


    protected $image;

    #[Groups(["burgers:read:simple", 'menu:write','write','menu:read:simple','menu:frite'])]
    #[ORM\Column(type: 'float', nullable: true)]
    protected $prix;
    #[Groups(["burgers:read:simple",'menu:write','write'])]
    #[ORM\Column(type: 'boolean', nullable: true)]
    protected $etat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

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
}
