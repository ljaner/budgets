<?php

namespace App\Domain;

interface BudgetRepositoryInterface
{

    public function save(Budget $budget): Budget;

    public function findAll() : array;

    public function findOneBy(String $id): ?Budget;

    public function findByUserId(int $userId): array ;

}