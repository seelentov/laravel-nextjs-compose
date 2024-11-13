<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\File;
use App\Models\Folder;
use App\Models\User;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sampleFiles = [
            "/storage/seed/sample.jpg",
            "/storage/seed/sample.mp3",
            "/storage/seed/sample.mp4",
            "/storage/seed/sample.pdf",
        ];

        $folders = Folder::all();

        foreach ($folders as $folder) {
            foreach ($sampleFiles as $path) {
                File::create([
                    'name' => basename($path),
                    'path' => $path,
                    'user_id' => $folder->user_id,
                    'folder_id' => $folder->id,
                    'size' => 12345
                ]);
            }
        }

        $users = User::all();

        foreach ($users as $user) {
            foreach ($sampleFiles as $path) {
                File::create([
                    'name' => basename($path),
                    'path' => $path,
                    'user_id' => $user->id,
                    'folder_id' => null,
                    'size' => 12345
                ]);
            }
        }
    }
}
