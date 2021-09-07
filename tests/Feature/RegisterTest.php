<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_method()
    {
        $this->get(route('register.create'))
            ->assertViewIs('register.create')
            ->assertOk();
    }

    public function test_store_method()
    {
        $data = [
            'name' => 'mojix',
            'email' => 'email@gmail.com',
            'password' => '1234',
            'password_confirmation' => '1234',
        ];
        $response = $this->post('/register', $data);

        $this->assertCount(1, User::all());

        $this->assertDatabaseHas('users', ['email' => 'email@gmail.com']);

        $response->assertRedirect(route('login.create'));

    }

    public function test_name_is_required()
    {
        $response = $this->post('/register', [
            'name' => '',
        ]);
        $response->assertSessionHasErrors([
            'name' => 'The name field is required.'
        ]);
    }

    public function test_email_is_required()
    {
        $response = $this->post('/register', [
            'email' => '',
        ]);
        $response->assertSessionHasErrors([
            'email' => 'The email field is required.'
        ]);
    }

    public function test_password_is_required()
    {
        $response = $this->post('/register', [
            'password' => '',
        ]);
        $response->assertSessionHasErrors([
            'password' => 'The password field is required.'
        ]);
    }

    public function test_email_must_be_email_rule()
    {
        $response = $this->post('/register', [
            'email' => 'hello',
        ]);
        $response->assertSessionHasErrors([
            'email' => 'The email must be a valid email address.'
        ]);
    }

    public function test_password_must_be_confirmed_rule()
    {
        $response = $this->post('/register', [
            'password' => '1234',
            'password_confirmation' => '1',
        ]);
        $response->assertSessionHasErrors([
            'password' => 'The password confirmation does not match.'
        ]);
    }

    public function test_event_dispatched()
    {
        Event::fake();

        Event::assertNotDispatched(Registered::class);

        $data = [
            'name' => 'mojix',
            'email' => 'email@gmail.com',
            'password' => '1234',
            'password_confirmation' => '1234',
        ];
        $this->post('/register', $data);

        $this->assertCount(1, User::all());

        $this->assertDatabaseHas('users', ['email' => 'email@gmail.com']);

        Event::assertDispatched(Registered::class);

        Event::assertListening(Registered::class,SendEmailVerificationNotification::class);

    }

}
