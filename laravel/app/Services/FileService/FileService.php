<?php

namespace App\Services\FileService;

use App\Models\File;
use App\Services\Service;
use App\Services\UserService\UserService;
use Illuminate\Database\Eloquent\Collection;

class FileService extends Service implements IFileService
{
    public function __construct(
        private readonly File $files,
        private readonly UserService $userService
    ) {}
    public function getRootByUser(int $userId): Collection
    {
        $files = $this->files->where([
            ["user_id", $userId],
            ["folder_id", null]
        ])->get();
        return $files;
    }
    public function getById(int $folderId): File|null
    {
        $file = $this->files->find($folderId);
        return $file;
    }

    public function create(array $data)
    {
        $file = $data['file'];
        $user_id = $data['user_id'];

        $user = $this->userService->getById($user_id);

        $userFolder = $user->uuid;

        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $uniqueFilename = uniqid() . '_' . $filename . '.' . $file->getClientOriginalExtension();

        $filePath = 'uploads/' . $userFolder . '/' . $uniqueFilename;

        $file->storeAs('uploads/' . $userFolder, $uniqueFilename, 'public');

        $fileSize = $file->getSize();

        unset($data["file"]);

        $data["name"] = $filename;
        $data["path"] = $filePath;
        $data["size"] = $fileSize;

        $file = $this->files->create($data);
        return $file;
    }


    public function update(int $id, array $data)
    {
        $file = $this->files->where("id", $id)->update($data);
        return $file;
    }

    public function delete(int $id): void
    {
        $this->files->destroy($id);
    }
}
