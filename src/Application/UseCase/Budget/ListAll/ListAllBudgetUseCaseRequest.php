<?php


namespace App\Application\UseCase\Budget\ListAll;


class ListAllBudgetUseCaseRequest
{

    /**
     * @var string
     */
    private $email;

    public function getEmail(): ? string
    {
        return $this->email;
    }

    public function setEmail($email): ? self
    {
        $this->email = $email;

        return $this;
    }

}