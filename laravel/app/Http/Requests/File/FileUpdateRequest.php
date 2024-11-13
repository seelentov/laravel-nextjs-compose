<?php

namespace App\Http\Requests\File;



class FileUpdateRequest extends FileRequest
{

    public function rules(): array
    {
        return [
            'name' => 'string',
        ];
    }
}
