<?php

namespace App\Http\Requests\File;



class FileStoreRequest extends FileRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|file',
            'folder_id' => 'integer|exists:folders,id',
        ];
    }
}
