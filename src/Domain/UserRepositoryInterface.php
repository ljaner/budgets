<?php

namespace App\Domain;

interface UserRepositoryInterface
{
    public function findOneByEmail(String $email): ?User;

    public function save(User $user): User;

}