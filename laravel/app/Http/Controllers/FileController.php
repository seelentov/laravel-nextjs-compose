<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\FileStoreRequest;
use App\Http\Requests\File\FileUpdateRequest;
use App\Services\FileService\FileService;

class FileController extends Controller
{
    public function __construct(private readonly FileService $files) {}

    public function show($id)
    {
        $file = $this->files->getById($id);

        if (is_null($file)) {
            return response()->json(["message" => "Not found"], 404);
        }

        if ($file->user_id != auth()->userOrFail()->id) {
            return response()->json(["message" => "Unathorized"], 404);
        }

        return response()->json($file);
    }
    public function store(FileStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->userOrFail()->id;

        $folder = $this->files->create($data);

        return response()->json($folder);
    }

    public function update(int $id, FileUpdateRequest $request)
    {
        $data = $request->validated();

        $file = $this->files->getById($id);

        if (is_null($file)) {
            return response()->json(["message" => "Not found"], 404);
        }

        if ($file->user_id != auth()->userOrFail()->id) {
            return response()->json(["message" => "Unathorized"], 404);
        }

        $file = $this->files->update($id, $data);

        return response()->json($file);
    }

    public function remove(int $id)
    {
        $file = $this->files->getById($id);

        if (is_null($file)) {
            return response()->json(["message" => "Not found"], 404);
        }

        if ($file->user_id != auth()->userOrFail()->id) {
            return response()->json(["message" => "Unathorized"], 404);
        }

        $this->files->delete($file->id);

        return response()->json(["message" => "Delete successfully"], 200);
    }
}
