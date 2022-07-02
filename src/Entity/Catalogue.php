<?php

namespace App\Entity;

use App\Entity\Menu;
use App\Entity\Burger;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
// use Symfony\Component\Validator\Constraints\Collection;

#[ApiResource(
    collectionOperations:[
        "get_catalogue" => [
        "method"=>"get",
        'status' => Response::HTTP_OK,
        'path'=>'catalogue/',
        // 'denormalization_context' => ['groups' => ['user:write']],
        'normalization_context' => ['groups' => ['catologue']]
        ]
    ],
        itemOperations:[]
)]

class Catalogue
{
    #[Groups(["catologue"])]
    private $burgers;
    #[Groups(["catologue"])]
    private $menus;

    public function __construct()
    {
        $this->burgers = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }

}