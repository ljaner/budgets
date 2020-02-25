<?php


namespace App\tests\Domain\Budget;


use App\Domain\Budget;
use App\Domain\Exceptions\BudgetAlreadyDiscarded;
use App\Domain\Exceptions\BudgetNotPending;
use App\Domain\User;
use PHPUnit\Exception;
use PHPUnit\Framework\TestCase;

final class BudgetTest extends TestCase
{
    public function testUpdateBudget()
    {
        $user = new User('email@gmail.com');
        $budget = new Budget($user);
        $budget->update('description', 'category', 'subcategory', '13/12/2019');
        $this->assertEquals($budget->getDescription(), "description");
        $this->assertEquals($budget->getDate(), "13/12/2019");
        $this->assertEquals($budget->getCategory(), "category");
        $this->assertEquals($budget->getSubCategory(), "subcategory");
    }

    public function testUpdateBudgetNotPending()
    {
        $user = new User('email@gmail.com');
        $budget = new Budget($user);
        $budget->setStatus(Budget::STATUS_PUBLISHED);
        $this->expectException(BudgetNotPending::class);
        $budget->update('description', 'category', 'subcategory', '13/12/2019');

    }

    public function testDiscardBudget()
    {
        $user = new User('email@gmail.com');
        $budget = new Budget($user);
        $budget->discard();
        $this->assertEquals($budget->getStatus(), Budget::STATUS_DISCARDED);
    }

    public function testDiscardBudgetAlreadyDiscarded()
    {
        $user = new User('email@gmail.com');
        $budget = new Budget($user);
        $budget->setStatus(Budget::STATUS_DISCARDED);
        $this->expectException(BudgetAlreadyDiscarded::class);
        $budget->discard();
    }

    public function testPublishBudget()
    {
        $user = new User('email@gmail.com');
        $budget = new Budget($user);
        $budget->setCategory('category');
        $budget->publish();
        $this->assertEquals($budget->getStatus(), Budget::STATUS_PUBLISHED);
    }

    public function testPublishBudgetNotPending()
    {
        $user = new User('email@gmail.com');
        $budget = new Budget($user);
        $budget->setCategory('category');
        $budget->setStatus(Budget::STATUS_DISCARDED);
        $this->expectException(BudgetNotPending::class);
        $budget->publish();
    }

    public function testPublishBudgetEmptyCategory()
    {
        $user = new User('email@gmail.com');
        $budget = new Budget($user);
        $budget->setStatus(Budget::STATUS_DISCARDED);
        $this->expectException(\Exception::class);
        $budget->publish();
    }

}