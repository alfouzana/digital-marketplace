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
    public function a_user_can_view_registration_form()
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

        $response = $this->post('/register', [
            'name' => $user['name'],
            'email' => $user['email'],
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'type' => $user['type'],
        ]);

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email'],
            'type' => $user['type']
        ]);

        $response->assertRedirect($user->homeUrl());
    }

    /**
     * @test
     */
    public function passwords_should_be_hashed()
    {
        $data = factory(User::class)->raw();

        $this->post('/register', [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'type' => $data['type'],
        ]);

        $user = User::find(1);

        $this->assertTrue(Hash::check('secret', $user->password));
    }
}
