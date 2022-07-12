<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\Mapping\InheritanceType;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\DiscriminatorMap;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]

#[ApiResource ( attributes: ["pagination_items_per_page" => 5])]
    
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["produits"=>"Produits","menu"=>"Menu","burger"=>"Burger","boisson"=>"Boisson","portionfrite"=>"Portionfrite"])]

class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]


    #[Groups([
    "menu:write" ,'menu:frite',
    "menu:read:simple","collection:post_burger:read"])]
    protected $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['item:get_boissons',"burgers:read:simple","collection:post_burger:read",'collection:post_boissons:read','menu:read:simple','menu:frite',"tailles:write:simple","menu:write"])]
    protected $nom;
    
    #[ORM\Column(type:'blob', nullable: true)]
    protected $image;

    #[Groups(["burgers:read:simple", "collection:post_burger:read",'menu:frite','item:get_boissons',"tailles:write:simple"])]
    #[ORM\Column(type: 'float', nullable: true)]
    protected $prix;
    #[Groups(["burgers:read:simple","collection:post_burger:read"])]
    #[ORM\Column(type: 'boolean', nullable: true)]
    protected $etat;

    #[SerializedName("image")]
    #[Groups(["collection:post_burger:read","burgers:read:simple",'item:get_boissons','menu:frite','collection:post_boissons:read',"menu:write"])]

    private string $fileImage;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    #[Groups([
        "collection:post_burger:read","burgers:read:simple",
        "item:put_burger:read", "item:get_burger",
        "collection:post_frites:read",
        "item:put_frites:read", "item:get_frites",
        "collection:post_boissons:read","boisson:read",
        "item:put_boissons:read", "item:get_boissons",
        "post:read:menu"
    ])]
    private $gestionnaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getFileImage(): ?string
    {
        return $this->fileImage;
    }

    public function setFileImage(?string $fileImage): self
    {
        $this->fileImage = $fileImage;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return is_resource($this->image) ? utf8_encode(base64_encode(stream_get_contents($this->image))):$this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

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
