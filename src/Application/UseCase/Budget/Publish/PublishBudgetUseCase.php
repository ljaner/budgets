<?php


namespace App\Application\UseCase\Budget\Publish;


use App\Domain\Budget;
use App\Domain\BudgetRepositoryInterface;

class PublishBudgetUseCase
{
    private $budgetRepository;

    public function __construct(BudgetRepositoryInterface $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    public function execute(PublishBudgetUseCaseRequest $request): Budget
    {
        /** @var Budget $budget */
        $budget = $this->budgetRepository->findOneBy($request->getId());
        if(!$budget) throw new \RuntimeException('Budget not found');
        return $this->budgetRepository->save($budget->publish());
    }
}