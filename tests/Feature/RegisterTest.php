<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_user_can_view_registration_page()
    {
        $this->get('/register')
            ->assertSee('registration-form');
    }

    /**
     * @test
     */
    public function a_user_can_register()
    {
        $user = factory(User::class)->make();

        $this->register($user);

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email'],
            'type' => $user['type']
        ]);
    }

    /**
     * @test
     */
    public function a_user_should_be_redirected_to_their_home_after_registering()
    {
        $user = factory(User::class)->make();

        $this->register($user)->assertRedirect($user->homeUrl());
    }
    
    /**
     * @test
     */
    public function a_user_password_should_be_hashed_when_they_register()
    {
        $user = factory(User::class)->make();

        $this->register($user);

        $registeredUser = User::find(1);

        $this->assertTrue(Hash::check('secret', $registeredUser->password));
    }

    protected function register(User $user)
    {
        return $this->post('/register', [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'type' => $user['type'],
        ]);
    }
}
