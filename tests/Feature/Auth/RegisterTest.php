<?php

namespace Tests\Feature\Auth;

use App\Enums\UserTypes;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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
    public function a_user_can_register_as_a_vendor()
    {
        $registerData = $this->registerData(UserTypes::VENDOR);

        $response = $this->post('/register', $registerData);

        $this->assertDatabaseHas('users', array_except(
            $registerData, ['password', 'password_confirmation']
        ));

        $response->assertRedirect('/vendor');
    }

    /**
     * @test
     */
    public function a_user_can_register_as_a_customer()
    {
        $registerData = $this->registerData(UserTypes::CUSTOMER);

        $response = $this->post('/register', $registerData);

        $this->assertDatabaseHas('users', array_except(
            $registerData, ['password', 'password_confirmation']
        ));

        $response->assertRedirect('/customer');
    }

    /**
     * @test
     */
    public function a_user_may_not_register_as_an_admin()
    {
        $registerData = $this->registerData(UserTypes::ADMIN);

        $this->expectException(ValidationException::class);

        $this->post('/register', $registerData);
    }

    /**
     * @test
     */
    public function a_user_password_should_be_hashed_when_they_register()
    {
        $registerData = $this->registerData();

        $this->post('/register', $registerData);

        $registeredUser = User::find(1);

        $this->assertTrue(Hash::check(
            $registerData['password'], $registeredUser->password
        ));
    }
    
    /**
     * @test
     */
    public function an_authenticated_user_should_be_redirected_to_their_home_if_attempts_to_register()
    {
        $user = $this->signIn();

        $this->get('/register')
            ->assertRedirect($user->homeUrl());

        $this->post('/register', $this->registerData())
            ->assertRedirect($user->homeUrl());
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

    protected function registerData($userType = null)
    {
        $userType = is_null($userType) ?
            array_random([UserTypes::VENDOR, UserTypes::CUSTOMER]) :
            $userType;

        $userAttributes = factory(User::class)->raw([
            'type' => $userType,
        ]);

        return [
            'name' => $userAttributes['name'],
            'email' => $userAttributes['email'],
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'type' => $userAttributes['type'],
        ];
    }
}
