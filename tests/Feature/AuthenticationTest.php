<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_user_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->delete('/logout');

        $response->assertRedirect(route('login.create'));
    }

    public function test_can_not_user_logout()
    {
        $response = $this->get('/logout');

        $response->assertStatus(302);

        $response->assertRedirect(route('login.create'));
    }

    public function test_read_login_page()
    {
        $response = $this->get('/login');

        $response->assertViewIs('authentication.create');

        $response->assertStatus(200);

    }

    public function test_can_not_read_login_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/login');

        $response->assertStatus(302);

        $response->assertRedirect('/');

    }

    public function test_user_can_login()
    {

        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => $user->password,
        ];

        $response = $this->post('/login', $data);

        $this->assertEquals($user->first()->email, $data['email']);

        $this->assertEquals($user->first()->password, $data['password']);

        $this->actingAs($user);

        $response->assertRedirect('/');

    }

    public function test_user_invalid_password()
    {

        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 123,
        ];

        $response = $this->post('/login', $data);

        $response->assertSessionHasErrors([
            'error' => 'email or password is wrong'
        ]);

    }

    public function test_user_invalid_email()
    {

        $user = User::factory()->create();

        $data = [
            'email' => 'a@gmail.com',
            'password' => $user->password,
        ];

        $response = $this->post('/login', $data);

        $response->assertSessionHasErrors([
            'email' => 'The selected email is invalid.',
        ]);

    }

    public function test_email_is_required()
    {

        $response = $this->post('/login', [
            'email' => '',
            'password' => '123456789',
        ]);
        $response->assertSessionHasErrors([
            'email' => 'The email field is required.'
        ]);
    }

    public function test_password_is_required()
    {

        $response = $this->post('/login', [
            'email' => 'mojix@email.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field is required.'
        ]);
    }

    public function test_email_has_valid_rule()
    {
        $response = $this->post('/login', [
            'email' => 'mojix',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email must be a valid email address.'
        ]);
    }

    public function test_email_must_be_exists_in_users()
    {
        $response = $this->post('/login', [
            'email' => 'a@gmail.com',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The selected email is invalid.'
        ]);
    }

    public function test_user_not_verified_email()
    {

        $user = User::factory()->unverified()->create();

        $data = [
            'email' => $user->email,
            'password' => $user->password,
        ];

        $this->post('/login', $data);

        $this->assertEquals($user->first()->email, $data['email']);

        $this->assertEquals($user->first()->password, $data['password']);

        $this->assertNull($user->first()->email_verified_at);

        $this->actingAs($user)
            ->get(route('verification.notice'))
            ->assertViewIs('verify-email.verifyEmails');



    }
}
