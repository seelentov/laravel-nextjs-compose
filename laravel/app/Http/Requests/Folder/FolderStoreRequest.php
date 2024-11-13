<?php

namespace App\Http\Requests\Folder;



class FolderStoreRequest extends FolderRequest
{
    public function rules(): array
    {
        return [
            'name' => 'string|required',
            'parent_id' => 'integer|exists:folders,id',
        ];
    }
}
