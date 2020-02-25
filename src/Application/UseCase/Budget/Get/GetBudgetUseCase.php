<?php


namespace App\Application\UseCase\Budget\Get;


use App\Domain\Budget;
use App\Domain\BudgetRepositoryInterface;
use Doctrine\ORM\Mapping\Id;
use PhpParser\Node\Expr\Cast\Object_;

class GetBudgetUseCase
{
    private $budgetRepository;

    public function __construct(BudgetRepositoryInterface $budgetRepository)
    {
        $this->budgetRepository = $budgetRepository;
    }

    public function execute(GetBudgetUseCaseRequest $request): ?Budget
    {
        $budget = $this->budgetRepository->findOneBy($request->getId());
        if(!$budget) throw new \RuntimeException('Budget not found');
        return $budget;
    }
}