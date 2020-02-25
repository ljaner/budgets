<?php

namespace App\Infrastructure\Repository;


use App\Domain\Budget;
use App\Domain\BudgetRepositoryInterface;
use App\Domain\User;
use Doctrine\ORM\EntityManagerInterface;

class BudgetRepositoryDoctrine implements BudgetRepositoryInterface
{

    private $entityRepository;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityRepository = $entityManager->getRepository(Budget::class);
        $this->entityManager = $entityManager;
    }

    public function findAll() : array
    {
        return $this->entityRepository->findAll();
    }

    public function findByUserId(int $userId): array
    {
        return  $this->entityRepository->findBy(array('user' => $userId));
    }

    public function findOneBy(String $id): ?Budget
    {
        return $this->entityRepository->findOneBy(array('id' => $id));
    }

    public function save(Budget $budget): Budget
    {
        $this->entityManager->persist($budget);
        $this->entityManager->flush();
        return $budget;
    }

}
