<?php


namespace App\Application\UseCase\Budget\ListAll;


use App\Domain\Budget;
use App\Domain\BudgetRepositoryInterface;
use App\Domain\UserRepositoryInterface;
use Doctrine\ORM\Mapping\Id;

class ListAllBudgetUseCase
{
    private $budgetRepository;
    private $userRepository;

    public function __construct(
        BudgetRepositoryInterface $budgetRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->budgetRepository = $budgetRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(ListAllBudgetUseCaseRequest $request): array
    {
        if(!$request->getEmail()) {
            return $this->budgetRepository->findAll();
        }
        $user = $this->userRepository->findOneByEmail($request->getEmail());
        return  $user ? $this->budgetRepository->findByUserId($user->getId()) : [];
    }
}