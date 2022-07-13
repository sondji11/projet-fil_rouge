<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComplementRepository;
use Doctrine\ORM\Mapping as ORM;

// #[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ApiResource(
    attributes: ["pagination_items_per_page" => 5]
    
)]
class Complement 
{
    
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
