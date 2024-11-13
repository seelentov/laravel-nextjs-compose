<?php

namespace App\Http\Requests\Folder;


class FolderUpdateRequest extends FolderRequest
{

    public function rules(): array
    {
        return [
            'name' => 'string',
        ];
    }
}
