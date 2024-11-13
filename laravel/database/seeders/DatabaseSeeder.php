<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(3)->create();



        $this->call([
            UserSeeder::class,
            FolderSeeder::class,
            FileSeeder::class,
        ]);
    }
}
