<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Filament\Commands\MakeUserCommand as FilamentMakeUserCommand;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Создание админа с Filament
        // $filamentMakeUserCommand = new FilamentMakeUserCommand();
        // $reflector = new \ReflectionObject($filamentMakeUserCommand);

        // $getUserModel = $reflector->getMethod('getUserModel');
        // $getUserModel->setAccessible(true);
        // $getUserModel->invoke($filamentMakeUserCommand)::create([
        //     'name' => env("ADMIN_NAME"),
        //     'email' => env("ADMIN_EMAIL"),
        //     'password' => bcrypt(env("ADMIN_PASSWORD")),
        // ]);

        User::factory()->create([
            'name' => env("ADMIN_NAME"),
            'email' => env("ADMIN_EMAIL"),
            'password' => bcrypt(env("ADMIN_PASSWORD")),
        ]);
    }
}
