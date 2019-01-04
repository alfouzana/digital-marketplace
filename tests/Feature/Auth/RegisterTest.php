<?php

namespace Tests\Feature\Auth;

use App\Enums\UserTypes;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function a_user_can_view_registration_page()
    {
        $this->get('/register')
            ->assertSee(__('Register'));
    }

    /**
     * @test
     */
    public function a_user_can_register()
    {
        $this->post('/register', $input = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])->assertRedirect('/user');

        $this->assertDatabaseHas('users', [
            'name' => $input['name'],
            'email' => $input['email'],
            'is_admin' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->assertTrue(
            Hash::check(
                $input['password'],
                 DB::table('users')
                    ->where('email', $input['email'])
                    ->first()->password
             )
        );
    }
    
    /**
     * @test
     */
    public function an_authenticated_user_should_be_redirected_to_their_home_if_attempts_to_register()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get('/register')
            ->assertRedirect('/user');

        $this->post('/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])->assertRedirect('/user');
    }

    /**
     * @test
     */
    public function an_authenticated_admin_should_be_redirected_to_their_home_if_attempts_to_register()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->actingAs($admin);

        $this->get('/register')
            ->assertRedirect('/admin');

        $this->post('/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ])->assertRedirect('/admin');
    }
}
