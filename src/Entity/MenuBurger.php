<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenuBurgerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use Symfony\Component\Security\Core\Authentication\RememberMe\PersistentToken;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
#[ApiResource(
)]
class MenuBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("menu:write")]
    private $id;

    #[ORM\Column(type: 'integer', length: 255, nullable: true)]
    #[Groups("menu:write")]
    #[assert\positive(Message:"la quantite doit etre superieur a 0")]
    private $quantiterburger;
    
    #[Groups("menu:write")]
    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    #[assert\positive(Message:"la quantite doit etre superieur a 0")]
    // #[SerializedName()]
    private $burger;
    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuburgers')]
    private $menu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiterburger(): ?string
    {
        return $this->quantiterburger;
    }

    public function setQuantiterburger(?string $quantiterburger): self
    {
        $this->quantiterburger = $quantiterburger;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

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
