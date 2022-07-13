<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuPortionRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuPortionRepository::class)]
#[ApiResource]
class MenuPortion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("menu:write","collection:post_frites:read")]
    private $id;
    #[Groups("menu:write")]
    #[ORM\Column(type: 'integer', length: 255, nullable: true)]
    private $quantitefrite;
    #[Groups("menu:write")]
    #[ORM\ManyToOne(targetEntity: Portionfrite::class, inversedBy: 'menuPortions')]
    private $portionfrite;



    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: self::class)]
    private $menuPortions;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'Menuportions')]
    private $menu;

    public function __construct()
    {
        $this->menuPortions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantitefrite(): ?string
    {
        return $this->quantitefrite;
    }

    public function setQuantitefrite(?string $quantitefrite): self
    {
        $this->quantitefrite = $quantitefrite;

        return $this;
    }

    public function getPortionfrite(): ?Portionfrite
    {
        return $this->portionfrite;
    }

    public function setPortionfrite(?Portionfrite $portionfrite): self
    {
        $this->portionfrite = $portionfrite;

        return $this;
    }


    /**
     * @return Collection<int, self>
     */
    public function getMenuPortions(): Collection
    {
        return $this->menuPortions;
    }

    public function addMenuPortion(self $menuPortion): self
    {
        if (!$this->menuPortions->contains($menuPortion)) {
            $this->menuPortions[] = $menuPortion;
            // $menuPortion->setMenu($this);
        }

        return $this;
    }

    public function removeMenuPortion(self $menuPortion): self
    {
        if ($this->menuPortions->removeElement($menuPortion)) {
            // set the owning side to null (unless already changed)
            if ($menuPortion->getMenu() === $this) {
                $menuPortion->setMenu(null);
            }
        }

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
