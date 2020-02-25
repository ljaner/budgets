<?php


namespace App\Application\UseCase\Budget\Update;


class UpdateBudgetUseCaseRequest
{


    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $category;

    /**
     * @var string
     */
    private $subcategory;


    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDescription(): ? string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ? string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCategory(): ? string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubCategory(): ? string
    {
        return $this->subcategory;
    }

    public function setSubCategory(string $subcategory): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }


}