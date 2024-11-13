<?php

namespace App\Http\Controllers;

use App\Http\Requests\Folder\FolderStoreRequest;
use App\Http\Requests\Folder\FolderUpdateRequest;
use App\Services\FileService\FileService;
use App\Services\FolderService\FolderService;

class FolderController extends Controller
{
    public function __construct(
        private readonly FolderService $folders,
        private readonly FileService $files
    ) {}

    public function index()
    {
        $folders = $this->folders->getRootByUser(auth()->userOrFail()->id);
        $files = $this->files->getRootByUser(auth()->userOrFail()->id);

        return response()->json([
            'folders' => $folders,
            'files' => $files,
        ]);
    }

    public function show($id)
    {
        $folder = $this->folders->getById($id);

        if (is_null($folder)) {
            return response()->json(["message" => "Not found"], 404);
        }

        if ($folder->user_id != auth()->userOrFail()->id) {
            return response()->json(["message" => "Unathorized"], 404);
        }

        return response()->json($folder);
    }

    public function store(FolderStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->userOrFail()->id;

        $folder = $this->folders->create($data);

        return response()->json($folder);
    }

    public function update(int $id, FolderUpdateRequest $request)
    {
        $data = $request->validated();

        $folder = $this->folders->getById($id);

        if (is_null($folder)) {
            return response()->json(["message" => "Not found"], 404);
        }

        if ($folder->user_id != auth()->userOrFail()->id) {
            return response()->json(["message" => "Unathorized"], 404);
        }

        $folder = $this->folders->update($id, $data);

        return response()->json($folder);
    }

    public function remove(int $id)
    {
        $folder = $this->folders->getById($id);

        if (is_null($folder)) {
            return response()->json(["message" => "Not found"], 404);
        }

        if ($folder->user_id != auth()->userOrFail()->id) {
            return response()->json(["message" => "Unathorized"], 404);
        }

        $this->folders->delete($folder->id);

        return response()->json(["message" => "Delete successfully"], 200);
    }
}
