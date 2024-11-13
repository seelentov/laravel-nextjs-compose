<?php

namespace App\Services\UserService;

use App\Models\User;
use App\Services\Service;
use Illuminate\Support\Str;


class UserService extends Service implements IUserService
{
    public function __construct(private readonly User $users) {}

    public function getById(int $id): User|null
    {
        return $this->users->find($id);
    }

    public function getByLogin(string $login): User|null
    {
        $res = $this->users->where("email", $login)->orWhere("phone", $login)->orWhere("name", $login);
        return $res->first();
    }

    public function getByName(string $name): User|null
    {
        $res = $this->users->where("name", $name);
        return $res->first();
    }

    public function getByEmail(string $email): User|null
    {
        $res = $this->users->where("email", $email);
        return $res->first();
    }

    public function getByPhone(string $phone): User|null
    {
        $res = $this->users->where("phone", $phone);
        return $res->first();
    }

    public function create(array $data): User
    {
        $data['password'] = bcrypt($data['password']);
        $data['uuid'] = Str::random(100);

        //Верификация сразу после регистрации
        $data['verified_at'] = now();

        $user = $this->users->create($data);

        return $user;
    }
}
