<?php

// src/DataPersister/UserDataPersister.php

namespace App\DataPersister;


use App\Entity\Produits;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Menu;
use App\Services\CalculPrixMenuService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 *
 */
class ProduitPersister implements DataPersisterInterface
    {
   
        private $_entityManager;
        private $menucalcul;
    


         public function __construct(EntityManagerInterface $entityManager,CalculPrixMenuService $menucalcul) {
                $this->_entityManager = $entityManager;
                $this->menucalcul = $menucalcul;

       
         }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Produits;
    }

    /**
     * @param Produits $data
     */
    public function persist($data, array $context = [])
        {
            if($data instanceof Menu){

                $data->setPrix($this->menucalcul->calculprix($data));
            }
            if ($data instanceof Produits ) 
            {
                if($data->getFileImage())
                {
                    $data->setImage(\file_get_contents($data->getFileImage()));
                }
            }
            $this->_entityManager->persist($data);
            $this->_entityManager->flush();
  
        }
        
    
    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}
