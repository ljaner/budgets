<?php


namespace App\Application\UseCase\Budget\Update;


use App\Domain\Budget;
use App\Domain\BudgetRepositoryInterface;

class UpdateBudgetUseCase
{
    private $budgetRepository;

    public function __construct(BudgetRepositoryInterface $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    public function execute(UpdateBudgetUseCaseRequest $request): Budget
    {
        /** @var Budget $budget */
        $budget = $this->budgetRepository->findOneBy($request->getId());
        if(!$budget) throw new \RuntimeException('Budget not found');
        $budget = $this->budgetRepository->save(
            $budget->update(
                $request->getDescription(),
                $request->getCategory(),
                $request->getSubCategory(),
                $request->getDate()
            )
        );
        return $budget;
    }
}