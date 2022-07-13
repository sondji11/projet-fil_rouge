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
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints\Cascade;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;




#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(

    collectionOperations:[

        "get"=>[

            'method'=>'get',

            'normalization_context'=>['groups'=>['menu:read:simple']]            

        ],"post"=>[
            "method"=>"post",
            'denormalization_context' => ['groups' => ['menu:write',]],
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource"

        ]
    ],
    itemOperations:[

        "get","put","delete"=>[
            
                'method' => 'delete',
                "path"=>"/menus/{id}" ,
                'requirements' => ['id' => '\d+'],
                'normalization_context' => ['groups' => ['delete']],
        ]

    ],
    attributes: ["pagination_items_per_page" => 5]

)]
class Menu extends Produits
{   
    #[Groups("menu:read:simple")]
    
        protected $prix;
    #[Groups("menu:read:simple")]

        protected $nom;
    #[Groups("menu:read:simple")]

        protected $image;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:["persist"])]
    #[assert\Valid]
   // #[assert\Callback]
    #[assert\Count(min:1,
    minMessage:'il faut au moins une burger dans le menu')]
    // #[SerializedName("burgers")]
    #[Groups("menu:write")]
    private $menuburgers;
    // #[assert\Callback]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTaille::class,cascade:["persist"])]
    #[Groups("menu:write")]
    private $menuTailles;
    // #[assert\Callback]
    #[Groups("menu:write")]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuPortion::class,cascade:["persist"])]
    private $Menuportions;

    

    
    public function __construct()
    {
      
        $this->quantiteBurgers = new ArrayCollection();
        $this->menuburgers = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
        $this->Menuportions = new ArrayCollection();

        
    }


    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuburgers(): Collection
    {
        return $this->menuburgers;
    }

    public function addMenuburger(MenuBurger $menuburger): self
    {
        if (!$this->menuburgers->contains($menuburger)) {
            $this->menuburgers[] = $menuburger;
            $menuburger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuburger(MenuBurger $menuburger): self
    {
        if ($this->menuburgers->removeElement($menuburger)) {
            // set the owning side to null (unless already changed)
            if ($menuburger->getMenu() === $this) {
                $menuburger->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenuTailles(): Collection
    {
        return $this->menuTailles;
    }

    public function addMenuTaille(MenuTaille $menuTaille): self
    {
        if (!$this->menuTailles->contains($menuTaille)) {
            $this->menuTailles[] = $menuTaille;
            $menuTaille->setMenu($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTaille $menuTaille): self
    {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getMenu() === $this) {
                $menuTaille->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuPortion>
     */
    public function getMenuportions(): Collection
    {
        return $this->Menuportions;
    }

    public function addMenuportion(MenuPortion $menuportion): self
    {
        if (!$this->Menuportions->contains($menuportion)) {
            $this->Menuportions[] = $menuportion;
            $menuportion->setMenu($this);
        }

        return $this;
    }

    public function removeMenuportion(MenuPortion $menuportion): self
    {
        if ($this->Menuportions->removeElement($menuportion)) {
            // set the owning side to null (unless already changed)
            if ($menuportion->getMenu() === $this) {
                $menuportion->setMenu(null);
            }
        }

        return $this;
    }

    

    public function validate(ExecutionContextInterface $context, $payload)
    {
        // somehow you have an array of "fake names"
        $fakeNames = [/* ... */];

        // check if the name is actually a fake name
        if (in_array($this->getMenuburgers(), $fakeNames)) {
            $context->buildViolation('This name sounds totally fake!')
                ->atPath('menuburgers')
                ->addViolation();
        }
    }
    

   


   

   
}
