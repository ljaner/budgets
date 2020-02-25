<?php


namespace App\Infrastructure\Transformers;


use App\Domain\Budget;

class BudgetJsonTransformer
{
    public function transform(Budget $budget)
    {
        return is_null($budget)? [] : [
            'id' => $budget->getId(),
            'description' => $budget->getDescription(),
            'status' => $budget->getStatus(),
            'date' => $budget->getDate(),
            'category' => $budget->getCategory(),
            'subcategory' => $budget->getSubCategory()
        ];
    }

    public function transforms(array $budgets)
    {
        $response = array();
        foreach ($budgets as $budget) {
            array_push($response, $this->transform($budget));
        }
        return $response;
    }

    public function transformWithUser(Budget $budget)
    {
        return is_null($budget)? [] : [
            'id' => $budget->getId(),
            'description' => $budget->getDescription(),
            'status' => $budget->getStatus(),
            'date' => $budget->getDate(),
            'category' => $budget->getCategory(),
            'subcategory' => $budget->getSubCategory(),
            'user-email' => $budget->getUser()->getEmail(),
            'user-phone' => $budget->getUser()->getPhone(),
            'user-address' => $budget->getUser()->getAddress(),
        ];
    }

    public function transformsWithUser(array $budgets)
    {
        $response = array();
        foreach ($budgets as $budget) {
            array_push($response, $this->transformWithUser($budget));
        }
        return $response;
    }



}