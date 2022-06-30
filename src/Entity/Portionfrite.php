<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PortionfriteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortionfriteRepository::class)]
#[ApiResource(

    collectionOperations:[
        "get"=>[
            'method'=> 'get',
            'normalization_context'=>['groups'=>['menu:frite']]




        ],
        "post"=>[

            'method' => 'post',

            'denormalization_context' => ['groups' => ['menu:frite']]
        ]
    ],
    itemOperations:["get","put"]




)]
class Portionfrite extends Produits
{
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'portionfrites')]
    private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }

    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column(type: 'integer')]
    // private $id;

  

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->addPortionfrite($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removePortionfrite($this);
        }

        return $this;
    }

   
}
