<?php

namespace App\Domain;

use App\Domain\Exceptions\BudgetAlreadyDiscarded;
use App\Domain\Exceptions\BudgetNotPending;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="budgets")
 */
class Budget
{

    const STATUS_PENDING = 'Pending';
    const STATUS_PUBLISHED = 'Published';
    const STATUS_DISCARDED = 'Discarded';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subcategory;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="budgets")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    public function __construct(User $user)
    {
        $this->user = $user;
        $this->status = $this::STATUS_PENDING;
    }

    public function setId(int $id): ?self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ? string
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ? string
    {
        return $this->date;
    }

    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCategory(): ? string
    {
        return $this->category;
    }

    public function setCategory($category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSubCategory(): ? string
    {
        return $this->subcategory;
    }

    public function setSubCategory($subcategory): self
    {
        $this->subcategory = $subcategory;

        return $this;
    }

    public function getStatus(): ? string
    {
        return $this->status;
    }


    public function setStatus($status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ? User
    {
        return $this->user;
    }


    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function publish() :self
    {
        if($this->getStatus() != $this::STATUS_PENDING) {
            throw new BudgetNotPending();
        }
        if(is_null($this->getCategory())) {
            throw new \Exception();
        }
        $this->setStatus($this::STATUS_PUBLISHED);
        return $this;
    }

    public function discard() :self
    {
        if($this->getStatus() == $this::STATUS_DISCARDED) {
            throw new BudgetAlreadyDiscarded();
        }
        $this->setStatus($this::STATUS_DISCARDED);
        return $this;
    }

    public function update(
        String $description,
        String $category,
        String $subCategory,
        String $date
    ): self
    {
        if($this->getStatus() != $this::STATUS_PENDING) {
            throw new BudgetNotPending();
        }
        if($description)$this->setDescription($description);
        if($date)$this->setDate($date);
        if($category)$this->setCategory($category);
        if($subCategory)$this->setSubCategory($subCategory);
        return $this;

    }


}
