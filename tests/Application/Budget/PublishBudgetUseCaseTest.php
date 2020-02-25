<?php

namespace App\tests\Application\Budget;


use App\Application\UseCase\Budget\Publish\PublishBudgetUseCase;
use App\Application\UseCase\Budget\Publish\PublishBudgetUseCaseRequest;
use App\Domain\Budget;
use App\Domain\User;
use App\Infrastructure\Repository\BudgetRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class PublishBudgetUseCaseTest extends TestCase
{
    private $budgetRepositoryInMemory;

    public function setUp()
    {
        $this->budgetRepositoryInMemory = new BudgetRepositoryInMemory();
    }

    public function testPublishBudgetPending()
    {
        $user = new User('email@gmail.com');
        $budget = new Budget($user);
        $budget->setCategory('category');
        $this->budgetRepositoryInMemory->save($budget);

        $publishBudgetUseCase = new PublishBudgetUseCase($this->budgetRepositoryInMemory);

        $budget = $publishBudgetUseCase->execute( new PublishBudgetUseCaseRequest(1));

        $this->assertNotEmpty($budget);
    }

    public function testPublishBudgetPublished()
    {
        $user = new User('email@gmail.com');
        $budget = new Budget($user);
        $budget->setCategory('category');
        $this->budgetRepositoryInMemory->save($budget);

        $publishBudgetUseCase = new PublishBudgetUseCase($this->budgetRepositoryInMemory);

        $budget = $publishBudgetUseCase->execute( new PublishBudgetUseCaseRequest(1));

        $this->assertNotEmpty($budget);
    }

}