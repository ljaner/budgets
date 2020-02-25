<?php


namespace App\Application\UseCase\Budget\Discard;


use App\Domain\Budget;
use App\Domain\BudgetRepositoryInterface;

class DiscardBudgetUseCase
{
    private $budgetRepository;

    public function __construct(BudgetRepositoryInterface $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    public function execute(DIscardBudgetUseCaseRequest $request): Budget
    {
        /** @var Budget $budget */
        $budget = $this->budgetRepository->findOneBy($request->getId());
        if(!$budget) throw new \RuntimeException('Budget not found');
        $budget = $this->budgetRepository->save(
            $budget->discard(
            )
        );
        return $budget;
    }
}