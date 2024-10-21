<?php

namespace Tests\Unit\BaseServices;

use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class RedisTest extends TestCase
{
    /**
     * A basic unit test example.
     */


    public function test_it_can_set_get(): void
    {
        Redis::set("foo", "bar");

        $foo = Redis::get("foo");

        $this->assertEquals("bar", $foo);
    }

    public function test_it_can_del(): void
    {
        Redis::set("foo", "bar");

        $foo = Redis::get("foo");

        Redis::del("foo");

        $foo_after_del = Redis::get("foo");

        $this->assertNotEquals($foo, $foo_after_del);
    }

    public function test_it_can_set_get_with_ttl(): void
    {
        Redis::set("foo", "bar", 'EX', 5);

        $foo = Redis::get("foo");

        $this->assertEquals("bar", $foo);

        sleep(6);

        $foo_after_ttl = Redis::get("foo");

        $this->assertNull($foo_after_ttl);
    }

    public function test_it_can_store_and_retrieve_arrays(): void
    {
        $data = ['name' => 'John Doe', 'age' => 30];
        Redis::set("user", json_encode($data));

        $user = json_decode(Redis::get("user"), true);

        $this->assertEquals($data, $user);
    }

    public function test_it_can_use_expire_to_set_ttl(): void
    {
        Redis::set("foo", "bar");

        Redis::expire("foo", 10);

        $ttl = Redis::ttl("foo");

        $this->assertTrue($ttl >= 9 && $ttl <= 10);
    }
}
