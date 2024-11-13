<?php

namespace App\Services\UserService;

use App\Models\User;

interface IUserService
{
    public function getById(int $id): User|null;
    public function getByLogin(string $login): User|null;
    public function getByName(string $name): User|null;
    public function getByEmail(string $email): User|null;
    public function getByPhone(string $phone): User|null;
    public function create(array $data): User;
}
