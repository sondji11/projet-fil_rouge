<?php

// src/DataPersister/UserDataPersister.php

namespace App\DataPersister;


use App\Entity\User;
use App\Services\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 *
 */
class DataPersister implements DataPersisterInterface
{
    private $_entityManager;

    private $_passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager,UserPasswordHasherInterface $passwordEncoder ,MailerService $mailerService) {
        $this->_entityManager = $entityManager;
        $this->_passwordEncoder = $passwordEncoder;
        $this->mailerService = $mailerService;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
        if ($data->getPassword()) {

            $data->setPassword($this->_passwordEncoder->hashPassword($data, $data->getPassword()));

                $data->eraseCredentials();

        }

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
        // $this->mailerService->SendEmail($data);
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
