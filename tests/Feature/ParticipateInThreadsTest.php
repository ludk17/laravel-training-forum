<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_user_may_not_add_replies()
    {
        $this->expectException(AuthenticationException::class);
        $this->disableExceptionHandling()
            ->post('threads/pg/1/replies', []);
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = create(User::class));

        $thread = create(Thread::class);

        $reply = make(Reply::class);
        $this->post("threads/{$thread->channel->name}/{$thread->id}/replies", $reply->toArray());

        $this->get("threads/{$thread->channel->name}/{$thread->id}")
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->publishReply(['body' => null])
            ->assertSessionHasErrors();
    }

    private function publishReply($override = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = create(Thread::class);
        $reply = make(Reply::class, $override);

        return $this->post(
            "/threads/{$thread->channel->name}/{$thread->id}/replies",
            $reply->toArray()
        );
    }
}
