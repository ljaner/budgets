<?php


namespace App\Application\UseCase\Budget\Get;


class GetBudgetUseCaseRequest
{

    /**
     * @var string
     */
    private $id;


    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): ? string
    {
        return $this->id;
    }

}