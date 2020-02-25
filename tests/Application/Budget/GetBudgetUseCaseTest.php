<?php


namespace App\tests\Application\Budget;
use App\Application\UseCase\Budget\Get\GetBudgetUseCase;
use App\Application\UseCase\Budget\Get\GetBudgetUseCaseRequest;
use App\Domain\Budget;
use App\Domain\User;
use App\Infrastructure\Repository\BudgetRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class GetBudgetUseCaseTest extends TestCase
{
    private $budgetRepositoryInMemory;

    public function setUp()
    {
        $this->budgetRepositoryInMemory = new BudgetRepositoryInMemory();
    }

    public function testGetBudgetNotExists()
    {
        $getBudgetUseCase = new GetBudgetUseCase($this->budgetRepositoryInMemory);

        $this->expectException(\RuntimeException::class);
        $budget = $getBudgetUseCase->execute( new GetBudgetUseCaseRequest("1"));

        $this->assertEmpty($budget);
    }


    public function testGetBudgetExists()
    {
        $getBudgetUseCase = new GetBudgetUseCase($this->budgetRepositoryInMemory);

        $user = new User('email@gmail.com');
        $budget = new Budget($user);
        $this->budgetRepositoryInMemory->save($budget);

        $budget = $getBudgetUseCase->execute( new GetBudgetUseCaseRequest("1"));

        $this->assertNotEmpty($budget);
    }



}