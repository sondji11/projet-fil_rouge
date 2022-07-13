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
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",

            'denormalization_context' => ['groups' => ['collection:post_frites:read']]
        ]
    ],
    itemOperations:[
        "get"=>[
            'method'=>"get",
            "normalization_context" => ["groups" => ["item:get_frites:read"]],
            "denormalization_context" => ["groups" => ["item:get_frites:write"]]


    ]
    ,"put"=>[
        'method'=>'put',
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
        "normalization_context" => ["groups" => ["item:put_frites:read"]],
        "denormalization_context" => ["groups" => ["item:put_frites:write"]]
    
    ]]




)]
class Portionfrite extends Produits
{
   

    #[ORM\OneToMany(mappedBy: 'portionfrite', targetEntity: MenuPortion::class)]
    private $menuPortions;

    public function __construct()
    {
       
        $this->menuPortions = new ArrayCollection();
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
     * @return Collection<int, MenuPortion>
     */
    public function getMenuPortions(): Collection
    {
        return $this->menuPortions;
    }

    public function addMenuPortion(MenuPortion $menuPortion): self
    {
        if (!$this->menuPortions->contains($menuPortion)) {
            $this->menuPortions[] = $menuPortion;
            $menuPortion->setPortionfrite($this);
        }

        return $this;
    }

    public function removeMenuPortion(MenuPortion $menuPortion): self
    {
        if ($this->menuPortions->removeElement($menuPortion)) {
            // set the owning side to null (unless already changed)
            if ($menuPortion->getPortionfrite() === $this) {
                $menuPortion->setPortionfrite(null);
            }
        }

        return $this;
    }

   
}
