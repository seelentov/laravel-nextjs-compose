<?php

namespace App\Http\Requests\Auth;


class AuthIndexRequest extends AuthRequest
{
    public function rules(): array
    {
        return [
            'login' => 'string|required',
            'password' => 'string|required|min:8',
        ];
    }
}
