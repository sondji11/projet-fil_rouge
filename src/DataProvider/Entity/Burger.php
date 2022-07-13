<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
 #[ApiResource (
    collectionOperations:[
        "get"=>[
        'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['burgers:read:simple']],
        ],
        "post"=>[
        'method' => 'post',
        "security" => "is_granted('ROLE_GESTIONNAIRE')",
        "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
        'denormalization_context' => ['groups' => ['collection:post_burger:read']],
        
        ]
        ],
        itemOperations:[
                        "get"=>[    
                        'method' => 'get',
                        'normalization_context' => ['groups' => ['item:get_burger:read']],
                        ],
                        "put"=>[
                            "security" => "is_granted('ROLE_GESTIONNAIRE')",
                            "security_message"=>"Vous n'avez pas access à cette Ressource",
                            "normalization_context" => ["groups" => ["item:put_burger:read"]],
                            "denormalization_context" => ["groups" => ["item:put_burger:write"]]
                           
                            ],
                    ] ,
  attributes: ["pagination_items_per_page" => 5]
   )]
 

class Burger extends Produits
{
    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'burgers')]

    private $menu;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
    private $menuBurgers;

    public function __construct()
    {
        $this->menuBurgers = new ArrayCollection();
    }

     #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'burgers')]
    private $gestionnaire; 

    

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

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
 
    // public function getCatalogue(): ?Catalogue
    // {
    //     return $this->catalogue;
    // }

    // public function setCatalogue(?Catalogue $catalogue): self
    // {
    //     $this->catalogue = $catalogue;

    //     return $this;
    // }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }

   
}
