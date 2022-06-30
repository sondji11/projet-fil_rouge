<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>
        [
            "method"=>"get",
            "normalization_context" => ['groups' => ['boisson:write']]


        ],
        "post"=>
        [
            "method"=>"post",
            "denormalization_context" => ['groups' => ['boisson:write']],
            "normalization_context" => ['groups' => ['boisson:write']]

        ]
    ],
    itemOperations:[
        "get"=>[
            'method' => 'get',
            "path"=>"/boissons/{id}" ,
            'requirements' => ['id' => '\d+'],
            'normalization_context' => ['groups' => ['All']],
            ],

            "put"=>[
                'method' => 'put',
                "path"=>"/boissons/{id}" ,
                'requirements' => ['id' => '\d+'],
                'normalization_context' => ['groups' => ['All']],
                ],


    ]


)]
class Boisson extends Produits
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    // private $id;
    #[ORM\ManyToMany(targetEntity: Taille::class, inversedBy: 'boissons')]
    private $boissons;

    public function __construct()
    {
        $this->boissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Taille $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Taille $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }
}
