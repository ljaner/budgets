<?php


namespace App\Infrastructure\Transformers;


use App\Domain\User;

class UserJsonTransformer
{


    private $budgetJsonTransform;


    public function __construct(BudgetJsonTransformer $budgetJsonTransform)
    {
        $this->budgetJsonTransform = $budgetJsonTransform;
    }

    public function transform(User $user)
    {
        return is_null($user)? [] : [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'address' => $user->getAddress(),
            'phone' => $user->getPhone(),

        ];
    }
    public function transforms(array $users)
    {
        $response = array();
        foreach ($users as $user) {
            array_push($response, $this->transform($user));
        }
        return $response;
    }

    public function transformWithBudget(User $user)
    {
        if(is_null($user)) return [];
        $response = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'address' => $user->getAddress(),
            'phone' => $user->getPhone(),
        ];
        foreach ($user->getBudgets() as $budget) {
            array_push($response['budgets'], $this->budgetJsonTransform->transform($budget));
        }
        return $response;
    }
    public function transformsWithBudget(array $users)
    {
        $response = array();
        foreach ($users as $user) {
            array_push($response, $this->transformWithBudget($user));
        }
        return $response;
    }



}