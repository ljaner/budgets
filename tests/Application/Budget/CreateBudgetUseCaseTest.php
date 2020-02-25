<?php


namespace App\tests\Application\Budget;

use App\Application\UseCase\Budget\Create\CreateBudgetUseCase;
use App\Application\UseCase\Budget\Create\CreateBudgetUseCaseRequest;
use App\Domain\User;
use App\Infrastructure\Repository\BudgetRepositoryInMemory;
use App\Infrastructure\Repository\UserRepositoryInMemory;
use PHPUnit\Framework\TestCase;

final class CreateBudgetUseCaseTest extends TestCase
{
    private $userRepositoryInMemory;
    private $budgetRepositoryInMemory;

    public function setUp()
    {
        $this->userRepositoryInMemory = new UserRepositoryInMemory();
        $this->budgetRepositoryInMemory = new BudgetRepositoryInMemory();
    }

    public function testCreateBudgetNewUser()
    {
        $createBudgetUseCase = new CreateBudgetUseCase($this->budgetRepositoryInMemory, $this->userRepositoryInMemory);

        $request = $this->_getBudgetRequest();
        $budget = $createBudgetUseCase->execute($request);

        $user = $this->userRepositoryInMemory->findOneByEmail("some@gmail.com");
        $this->assertNotEmpty($budget);
        $this->assertNotEmpty($user);
        $this->assertEquals($budget->getDescription(), "description");
        $this->assertEquals($user->getName(), "Name");
    }

    public function testCreateBudgetOldUser()
    {
        $createBudgetUseCase = new CreateBudgetUseCase($this->budgetRepositoryInMemory, $this->userRepositoryInMemory);

        $user = new User('some@gmail.com');
        $user->setName("Name 1");
        $user->setPhone("77777777");
        $this->userRepositoryInMemory->save($user);

        $request = $this->_getBudgetRequest();
        $budget = $createBudgetUseCase->execute($request);

        $user = $this->userRepositoryInMemory->findOneByEmail("some@gmail.com");
        $this->assertNotEmpty($budget);
        $this->assertNotEmpty($user);
        $this->assertEquals($budget->getDescription(), "description");
        $this->assertEquals($user->getName(), "Name");
        $this->assertEquals($user->getPhone(), "666666666");
    }

    private function _getBudgetRequest()
    {
        return  new CreateBudgetUseCaseRequest("description", 'Category', 'subcategory', 'Name', 'some@gmail.com', '666666666', 'street n 21' );
    }
}