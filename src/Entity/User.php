<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;



#[ApiResource]

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["user"=>"User","livreur"=>"Livreur","gestionnaire"=>"Gestionnaire","client"=>"Client"])]



class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer')]
    #[Groups(['write','client:read:simple', "collection:post_burger:read", "collection:post_frites:read", "collection:post_boissons:read", "collection:post_taille:read",
    "item:put_burger:read", "item:put_frites:read", "item:put_taille:read", "item:put_boissons:read",
    "commande:write:post",
    "post:livraison:read", "post:livraison:write"])]
    protected $id;

    #[Groups(['client:write','client:read:simple'])]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    protected $email;

    #[Groups(['client:read:simple'])] 
    #[ORM\Column(type: 'json')]
    protected $roles = [];

    #[Groups(['client:write'])]
    #[ORM\Column(type: 'string',)]
    protected $password;


    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['client:write','client:read:simple'])] 
    protected $nom;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }
   

    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }
}
