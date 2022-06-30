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
 #[ApiResource ]
//     collectionOperations:[
//         "get"=>[
//         'method' => 'get',
//         'status' => Response::HTTP_OK,
//         'normalization_context' => ['groups' => ['burgers:read:simple']],
//         ],
//         "post"=>[
//         'method' => 'post',
//         'denormalization_context' => ['groups' => ['write']],
//         ]
//         ],
//         itemOperations:[
//                         "get"=>[
//                         'method' => 'get',
//                         "path"=>"/bugers/{id}" ,
//                         'requirements' => ['id' => '\d+'],
//                         'normalization_context' => ['groups' => ['all']],
//                         ],
//                         "put"=>[
//                             "security" => "is_granted('ROLE_GESTIONNAIRE')",
//                             "security_message"=>"Vous n'avez pas access à cette Ressource"
                           
//                             ],
//                     ]
//             )]
            

class Burger extends Produits
{
    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'burgers')]

    private $menu;
    #[Groups(["all"])]

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
}
