<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Folder;
use App\Models\User;

class FolderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all existing users
        $users = User::all();

        foreach ($users as $user) {
            $rootFolder = Folder::create([
                'name' => 'Root',
                'user_id' => $user->id,
            ]);

            $subFolders = [
                'Documents',
                'Images',
                'Videos',
                'Downloads',
            ];

            foreach ($subFolders as $name) {
                Folder::create([
                    'name' => $name,
                    'parent_id' => $rootFolder->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
