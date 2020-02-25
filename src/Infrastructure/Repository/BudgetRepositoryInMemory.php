<?php

namespace App\Infrastructure\Repository;


use App\Domain\Budget;
use App\Domain\BudgetRepositoryInterface;

class BudgetRepositoryInMemory implements BudgetRepositoryInterface
{

    private $budgets = [];

    public function __construct()
    {
    }

    public function findAll() : array
    {
        return $this->budgets;
    }

    public function findByUserId(int $userId): array
    {
        /** @var Budget $budget */
        foreach ($this->budgets as $budget) {
            if($budget->getUser()->getId() == $userId) return $budget;
        }
        return  null;
    }

    public function findOneBy(String $id): ?Budget
    {
        /** @var Budget $budget */
        foreach ($this->budgets as $budget) {
            if($budget->getId() == $id) return $budget;
        }
        return  null;
    }

    public function save(Budget $budget): Budget
    {
        $budget->setId(count($this->budgets) + 1);
        array_push($this->budgets, $budget);
        return $budget;
    }

}
