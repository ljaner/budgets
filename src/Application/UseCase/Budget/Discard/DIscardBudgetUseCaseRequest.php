<?php


namespace App\Application\UseCase\Budget\Discard;


class DIscardBudgetUseCaseRequest
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