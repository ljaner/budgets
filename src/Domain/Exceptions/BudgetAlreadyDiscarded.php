<?php


namespace App\Domain\Exceptions;


class BudgetAlreadyDiscarded extends \Exception
{
    protected $message = 'Budget is already Discarded';
}