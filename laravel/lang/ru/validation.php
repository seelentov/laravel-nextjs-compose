<?php

return [
    'required' => 'Поле :attribute обязательно для заполнения.',
    'string' => 'Поле :attribute должно быть строкой.',
    'unique' => 'Поле :attribute должно быть уникальным.',
    'email' => 'Поле :attribute должно быть действительным адресом электронной почты.',
    'digits_between' => 'Поле :attribute должно быть числом длиной от :min до :max.',
    'min' => [
        'string' => 'Поле :attribute должно содержать не менее :min символов.',
    ],
    'image' => 'The :attribute must be an image.',
    'mimes' => 'The :attribute must be a file of type: :values.',
    'max' => 'The :attribute may not be greater than :max kilobytes.',

    'attributes' => [
        'name' => 'Имя',
        'email' => 'Email',
        'phone' => 'Телефон',
        'password' => 'Пароль',
        'avatar' => 'Аватар',
        "code" => "Код",
        "text" => "Текст",
        "login" => "Логин",
    ],
];
