<?php

namespace App\Infrastructure\Repository;

use App\Domain\User;
use App\Domain\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserRepositoryDoctrine implements UserRepositoryInterface
{

    private $entityRepository;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityRepository = $entityManager->getRepository(User::class);
        $this->entityManager = $entityManager;
    }

    public function findOneByEmail(String $email): ?User
    {
        return $this->entityRepository->findOneBy(array('email' => $email));
    }

    public function save(User $user): User
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return $user;
    }

}
