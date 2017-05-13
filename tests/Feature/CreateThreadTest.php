<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_see_create_threads_page()
    {
        $this->expectException(AuthenticationException::class);
        $this->get('/threads/create');
    }

    /** @test */
    public function guest_cannot_see_the_create_thread_page()
    {
        $this->expectException(AuthenticationException::class);

        $this->get('/threads/create')
            ->redirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());

        $this->get('/threads/' . $thread->id)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
