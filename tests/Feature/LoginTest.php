<?php

namespace Tests\Feature;

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
}
