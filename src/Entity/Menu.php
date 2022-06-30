<?php

namespace App\Entity;

use App\Entity\Produits;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(

    collectionOperations:[

        "get"=>[

            'method'=>'get',

            'normalization_context'=>['groups'=>['menu:read:simple']]            

        ],"post"=>[

            "method"=>"post",

            'denormalization_context' => ['groups' => ['menu:write',"menu:frite"]] 

        ]
    ],
    itemOperations:[

        "get","put"

]
)]
class Menu extends Produits
{   
    #[ORM\ManyToMany(targetEntity: Portionfrite::class, inversedBy: 'menus')]
    #[Groups(['menu:write','menu:frite',])]
    private $portionfrites;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Burger::class)]
    #[Groups(['menu:write'])]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: Taille::class, inversedBy: 'menus')]
    #[Groups(['menu:write'])]
    private $tailles;

   

   

    public function __construct()
    {
        $this->portionfrites = new ArrayCollection();
        $this->burgers = new ArrayCollection();
        $this->tailles = new ArrayCollection();
        
        
    }

    /**
     * @return Collection<int, Portionfrite>
     */
    public function getPortionfrites(): Collection
    {
        return $this->portionfrites;
    }

    public function addPortionfrite(Portionfrite $portionfrite): self
    {
        if (!$this->portionfrites->contains($portionfrite)) {
            $this->portionfrites[] = $portionfrite;
        }

        return $this;
    }

    public function removePortionfrite(Portionfrite $portionfrite): self
    {
        $this->portionfrites->removeElement($portionfrite);

        return $this;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
            $burger->setMenu($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            // set the owning side to null (unless already changed)
            if ($burger->getMenu() === $this) {
                $burger->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        $this->tailles->removeElement($taille);

        return $this;
    }

   
    

   


   

   
}
