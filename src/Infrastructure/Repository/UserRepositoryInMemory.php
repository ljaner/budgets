<?php

namespace App\Infrastructure\Repository;

use App\Domain\User;
use App\Domain\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserRepositoryInMemory implements UserRepositoryInterface
{

    private $users = [];

    public function __construct()
    {
    }

    public function findOneByEmail(String $email): ?User
    {
        /** @var User $user */
        foreach ($this->users as $user) {
            if($user->getEmail() == $email) return $user;
        }
        return  null;
    }

    public function save(User $user): User
    {
        $user->setId(count($this->users) + 1);
        array_push($this->users, $user);
        return $user;
    }

}
