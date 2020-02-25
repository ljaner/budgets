<?php


namespace App\Domain\Exceptions;


class BudgetNotPending extends \Exception
{
    protected $message = 'Budget is not Pending';
}