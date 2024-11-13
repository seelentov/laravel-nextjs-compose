<?php

namespace App\Services\FolderService;

use App\Models\Folder;
use App\Services\Service;
use Illuminate\Database\Eloquent\Collection;

class FolderService extends Service implements IFolderService
{
    public function __construct(
        private readonly Folder $folders,
    ) {}

    public function getRootByUser(int $userId): Collection|Folder|null
    {
        $folders = $this->folders->where([
            ["user_id", $userId],
            ["parent_id", null]
        ])->get();
        return $folders;
    }

    public function getById(int $folderId): Folder|null
    {
        $folder = $this->folders->with('folders')->with('files')->find($folderId);
        return $folder;
    }

    public function create(array $data)
    {
        $folder = $this->folders->create($data);
        return $folder;
    }

    public function update(int $id, array $data)
    {
        $folder = $this->folders->where("id", $id)->update($data);
        return $folder;
    }

    public function delete(int $id): void
    {
        $this->folders->destroy($id);
    }
}
