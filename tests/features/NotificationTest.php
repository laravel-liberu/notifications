<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Notification;
use LaravelLiberu\Users\Models\User;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs($this->user = User::first());
    }

    /** @test */
    public function can_fetch_notifications_count()
    {
        $this->user->notify(new TestNotification());

        $this->get(route('core.notifications.count'))
            ->assertStatus(200)
            ->assertJson(['count' => 1]);

        $this->assertEquals(1, $this->user->unreadNotifications->count());
    }

    /** @test */
    public function can_fetch_notifications()
    {
        $this->get(route('core.notifications.index', [
            'offset' => 0,
            'paginate' => 100,
        ]))->assertStatus(200);
    }

    /** @test */
    public function can_mark_as_read()
    {
        $this->user->notify(new TestNotification());

        $notification = $this->user->notifications->first();

        $this->patch(
            route('core.notifications.read', [$notification->id], false)
        )->assertStatus(200)
            ->assertJsonFragment([
                'read_at' => $notification->refresh()->read_at->toJson(),
            ]);
    }

    /** @test */
    public function can_mark_all_as_read()
    {
        $this->user->notify(new TestNotification());

        $this->post(route('core.notifications.readAll'))
            ->assertStatus(200);

        $this->assertEquals(0, $this->user->fresh()->unreadNotifications->count());
    }

    /** @test */
    public function can_destroy_notification()
    {
        $this->user->notify(new TestNotification());

        $notification = $this->user->notifications->first();

        $this->delete(
            route('core.notifications.destroy', [$notification->id], false)
        )->assertStatus(200);

        $this->assertEquals(0, $this->user->notifications()->count());
    }

    /** @test */
    public function can_destroy_all_notifications()
    {
        $this->user->notify(new TestNotification());

        $this->delete(route('core.notifications.destroyAll'))
            ->assertStatus(200);

        $this->assertEquals(0, $this->user->notifications()->count());
    }
}

class TestNotification extends Notification
{
    public function __construct()
    {
        $this->body = 'testing';
    }

    public function via()
    {
        return ['database'];
    }

    public function toArray()
    {
        return [
            'body' => $this->body,
        ];
    }
}
