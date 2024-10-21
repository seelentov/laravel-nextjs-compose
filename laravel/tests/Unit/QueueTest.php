<?php

namespace Tests\Unit\Services;

use App\Jobs\TestJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class QueueTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('horizon:continue-supervisor', ['name' => 'supervisor-test']);
    }

    protected function tearDown(): void
    {
        $this->artisan('horizon:pause-supervisor', ['name' => 'supervisor-test']);

        parent::tearDown();
    }

    public function test_send_message_to_rabbitmq()
    {
        TestJob::dispatch();

        // Проверка, что сообщение было отправлено
        $this->assertTrue(Queue::connection('rabbitmq')->size('test') > 0);
    }

    public function test_send_message_to_rabbitmq_and_it_got_by_horizon()
    {
        // Отправка сообщения в очередь
        TestJob::dispatch();

        // Проверка, что сообщение было отправлено
        $this->assertTrue(Queue::connection('rabbitmq')->size('test') > 0);

        sleep(5);

        $this->assertTrue(Queue::connection('rabbitmq')->size('test') === 0);
    }
}
