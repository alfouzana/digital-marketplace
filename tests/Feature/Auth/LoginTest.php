<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_can_view_login_page()
    {
        $this->get('/login')
            ->assertSee('login-form');
    }

    /**
     * @test
     */
    public function a_user_can_login()
    {
        $user = factory(User::class)->create();

        $this->post('/login', [
            'email' => $user['email'],
            'password' => 'secret'
        ]);

        $this->assertTrue(Auth::check());
    }

    /**
     * @test
     */
    public function a_user_should_be_redirected_to_their_home_after_login()
    {
        $user = factory(User::class)->create();

        $this->post('/login', [
            'email' => $user['email'],
            'password' => 'secret'
        ])->assertRedirect($user->homeUrl());
    }

    /**
     * @test
     */
    public function an_authenticated_user_should_be_redirected_to_their_home_if_attempts_to_login()
    {
        $user = $this->signIn();

        $this->get('/login')
            ->assertRedirect($user->homeUrl());

        $this->post('/login')
            ->assertRedirect($user->homeUrl());
    }
}
