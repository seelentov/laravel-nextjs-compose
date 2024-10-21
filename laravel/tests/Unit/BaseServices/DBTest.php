<?php

namespace Tests\Unit\BaseServices;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DBTest extends TestCase
{
    use DatabaseTransactions;


    public function test_it_can_store_new_user()
    {
        $userData = [
            "name" => "John",
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password'),
        ];

        $newUser = User::create($userData);

        $this->assertDatabaseHas('users', $userData);
        $this->assertNotNull($newUser->id);
    }

    public function test_it_can_get_user()
    {
        $userData = [
            "name" => "John",
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password'),
        ];

        $user = User::factory()->create($userData);

        $this->assertTrue(User::find($user->id) !== null);
    }

    public function test_it_can_update_user()
    {
        $user = User::factory()->create();
        $updatedEmail = 'updated.email@example.com';

        $user->update(['email' => $updatedEmail]);

        $this->assertDatabaseHas('users', ['email' => $updatedEmail]);
    }

    public function test_it_can_delete_user()
    {
        $userData = [
            "name" => "John",
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password'),
        ];

        $user = User::factory()->create($userData);

        $user->delete();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
