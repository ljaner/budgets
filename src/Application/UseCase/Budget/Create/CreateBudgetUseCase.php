<?php


namespace App\Application\UseCase\Budget\Create;


use App\Application\UseCase\Budget\Create\CreateBudgetUseCaseRequest;
use App\Domain\Budget;
use App\Domain\BudgetRepositoryInterface;
use App\Domain\User;
use App\Domain\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;

class CreateBudgetUseCase
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

    public function execute(CreateBudgetUseCaseRequest $request): Budget
    {
        /** @var User $user */
        $user = $this->userRepository->findOneByEmail($request->getEmail());
        if($user) {
            $user->updateUser(
                $request->getName(),
                $request->getPhone(),
                $request->getAddress()
            );
        }else {
            $user = new User($request->getEmail());
            $user->setName($request->getName());
            $user->setPhone($request->getPhone());
            $user->setAddress($request->getAddress());
        }

        $this->userRepository->save($user);

        $budget = new Budget($user);
        $budget->setDescription($request->getDescription());
        $budget->setCategory($request->getCategory());
        $budget->setSubCategory($request->getSubCategory());
        if($request->getDate())$budget->setDate($request->getDate());
        return $this->budgetRepository->save($budget);

    }
}