<?php

namespace Tests\Feature;

use App\Mail\ForgetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class ForgetPasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_method()
    {
        $response = $this->get(route('forget.create'))
            ->assertViewIs('forget-password.create');

        $response->assertStatus(200);
    }

    public function test_email_is_required()
    {
        $response = $this->post(route('forget.store'), [
            'email' => '',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email field is required.',
        ]);
    }

    public function test_email_has_email_rule()
    {
        $response = $this->post(route('forget.store'), [
            'email' => 'hello',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email must be a valid email address.',
        ]);
    }

    public function test_email_must_be_exists_in_users()
    {
        $response = $this->post(route('forget.store'), [
            'email' => 'a@gamil.com',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The selected email is invalid.',
        ]);
    }

    public function test_store_method()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email
        ];

        $this->post(route('forget.store'), $data);

        $this->assertDatabaseCount('password_resets', 1);

        $this->withSession(['successful' => 'check your email and click on link'])
            ->get(route('forget.create'))->assertViewIs('forget-password.create');
    }

    public function test_reset_password_method()
    {
        $token = Str::random(64);

        $this->get(route('reset.password.create', $token))
            ->assertViewIs('forget-password.reset')
            ->assertViewHas([
                'token' => $token,
            ]);
    }

    public function test_email_for_password_reset_is_required()
    {
        $token = Str::random(64);

        $response = $this->post(route('reset.password.store', $token), [
            'email' => '',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email field is required.',
        ]);

    }

    public function test_password_field_for_password_reset_is_required()
    {
        $token = Str::random(64);

        $response = $this->post(route('reset.password.store', $token), [
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field is required.',
        ]);

    }

    public function test_password_field_for_password_reset_has_confirmed_rule()
    {
        $token = Str::random(64);

        $response = $this->post(route('reset.password.store', $token), [
            'password' => '1234',
            'password_confirmation' => '4321',
        ]);

        $response->assertSessionHasErrors([
            'password' => 'The password confirmation does not match.'
        ]);

    }

    public function test_email_field_for_password_reset_has_email_rule()
    {
        $token = Str::random(64);

        $response = $this->post(route('reset.password.store', $token), [
            'email' => 'hello',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The email must be a valid email address.',
        ]);

    }

    public function test_email_exists_in_users()
    {
        $token = Str::random(64);

        $response = $this->post(route('reset.password.store', $token), [
            'email' => 'a@gmail.com',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'The selected email is invalid.',
        ]);

    }

    public function test_reset_password_store_method()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'newPassword1234',
            'password_confirmation' => 'newPassword1234',
        ];

        $this->post(route('forget.store'), [
            'email' => $user->email,
        ]);

        $this->assertDatabaseCount('password_resets', 1);

        $token = DB::table('password_resets')->first()->token;

        $response = $this->post(route('reset.password.store', $token), $data);

        $this->assertTrue(Hash::check($data['password'], $user->fresh()->password));

        $this->assertEquals($data['email'], $user->fresh()->email);

        $this->assertDatabaseCount('password_resets', 0);

        $response->assertRedirect(route('login.create'));


    }

    public function test_email_must_be_send()
    {
        Mail::fake();

        Mail::assertNotSent(ForgetPasswordMail::class);

        $user = User::factory()->create();

        $data = [
            'email' => $user->email
        ];

        $this->post(route('forget.store'), $data);

        $this->assertDatabaseCount('password_resets', 1);

        Mail::assertSent(ForgetPasswordMail::class);

        $this->withSession(['successful' => 'check your email and click on link'])
            ->get(route('forget.create'))->assertViewIs('forget-password.create');
    }
}
