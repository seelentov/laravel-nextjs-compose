<?php

namespace App\Http\Requests\Auth;


class AuthStoreRequest extends AuthRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|required|unique:users,name',
            'email' => 'string|required|email|unique:users,email',
            'phone' => 'string|required|unique:users,phone|digits_between:10,15',
            'password' => 'string|required|min:8',
        ];
    }
}
