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
            ->assertSee(__('Login'));
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
        ])->assertRedirect('/user');

        $this->assertEquals($user->id, Auth::user()->id);
    }

    /**
     * @test
     */
    public function an_admin_can_login()
    {
        $admin = factory(User::class)->states('admin')->create();

        $this->post('/login', [
            'email' => $admin['email'],
            'password' => 'secret'
        ])->assertRedirect('/admin');

        $this->assertEquals($admin->id, Auth::user()->id);
    }

    /**
     * @test
     */
    public function a_user_can_not_login_with_incorrect_data()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'Wrong',
        ], [
            'referer' => url('/login'),
        ])->assertRedirect('/login');

        $this->assertFalse(Auth::check());

        $this->post('/login', [
            'email' => $user->name,
            'password' => 'secret',
        ], [
            'referer' => url('/login'),
        ])->assertRedirect('/login');

        $this->assertFalse(Auth::check());
    }

    /**
     * @test
     */
    public function an_authenticated_user_should_be_redirected_when_attempts_to_login()
    {
        $this->actingAs(
            factory(User::class)->create()
        );

        $this->get('/login')
            ->assertRedirect('/user');

        $this->post('/login')
            ->assertRedirect('/user');
    }


    /**
     * @test
     */
    public function an_authenticated_admin_should_be_redirected_when_attempts_to_login()
    {
        $this->actingAs(
            factory(User::class)->states('admin')->create()
        );

        $this->get('/login')
            ->assertRedirect('/admin');

        $this->post('/login')
            ->assertRedirect('/admin');
    }
}
