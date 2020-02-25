<?php


namespace App\Application\UseCase\Budget\Publish;


class PublishBudgetUseCaseRequest
{
    /**
     * @var int
     */
    private $id;


    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}