<?php

namespace Tests\Feature;

use App\Models\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_method()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.show', $user->id));

        $response->assertViewIs('profile.show');

        $response->assertViewHas(['user' => $user]);
    }

    public function test_user_can_not_read_profile()
    {
        $user = User::factory()->create();

        $response = $this->get(route('profile.show', $user->id));

        $response->assertRedirect(route('login.create'));
    }

    public function test_edit_method()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.edit', $user->id));

        $response->assertViewIs('profile.edit');

        $response->assertViewHas(['user' => $user]);
    }

    public function test_store_method()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'new_name',
            'email' => $user->email,
            'password' => 'newPassword1234',
            'password_confirmation' => 'newPassword1234',
        ];

        $response = $this->actingAs($user)
            ->patch(route('profile.update'), $data);

        $this->assertEquals($data['name'], User::query()->first()->name);

        $this->assertEquals($data['email'], User::query()->first()->email);

        $this->assertTrue( Hash::check($data['password'], User::query()->first()->password));

        $response->assertRedirect(route('profile.show', $user->id));
    }

    public function test_name_is_required()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->patch(route('profile.update'), [
                'name' => '',
            ]);

        $response->assertSessionHasErrors([
            'name' => 'The name field is required.'
        ]);

    }

    public function test_password_is_required()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->patch(route('profile.update'), [
                'password' => '',
            ]);

        $response->assertSessionHasErrors([
            'password' => 'The password field is required.'
        ]);

    }

    public function test_password_has_confirmed_rule()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->patch(route('profile.update'), [
                'password' => '1234',
                'password_confirmation' => '4321',
            ]);

        $response->assertSessionHasErrors([
            'password' => 'The password confirmation does not match.'
        ]);

    }

    public function test_email_has_email_rule()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->patch(route('profile.update'), [
                'email' => 'hello',
            ]);

        $response->assertSessionHasErrors([
            'email' => 'The email must be a valid email address.'
        ]);

    }

    public function test_email_must_be_unique()
    {
        $email_exists = User::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->patch(route('profile.update'), [
                'email' => $email_exists->first()->email,
            ]);

        $response->assertSessionHasErrors([
            'email' => 'The email has already been taken.',
        ]);
    }

    public function test_when_email_changed_email_verified_must_be_null()
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'new_name',
            'email' => 'a@gmail.com',
            'password' => 'newPassword1234',
            'password_confirmation' => 'newPassword1234',
        ];

        $response = $this->actingAs($user)
            ->patch(route('profile.update'), $data);

        $this->assertEquals($data['name'], $user->fresh()->name);

        $this->assertEquals($data['email'], $user->fresh()->email);

        $this->assertTrue( Hash::check($data['password'], $user->fresh()->password));

        $this->assertNull( $user->fresh()->email_verified_at);

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_event_dispatched()
    {
        $user = User::factory()->create();

        Event::fake();

        Event::assertNotDispatched(Registered::class);

        $data = [
            'name' => 'new_name',
            'email' => 'a@gmail.com',
            'password' => 'newPassword1234',
            'password_confirmation' => 'newPassword1234',
        ];

        $response = $this->actingAs($user)
            ->patch(route('profile.update'), $data);

        $this->assertEquals($data['name'], $user->fresh()->name);

        $this->assertEquals($data['email'], $user->fresh()->email);

        $this->assertTrue( Hash::check($data['password'], $user->fresh()->password));

        $this->assertNull( $user->fresh()->email_verified_at);

        Event::assertDispatched(Registered::class);

        Event::assertlistening(Registered::class, SendEmailVerificationNotification::class);

        $response->assertRedirect(route('verification.notice'));
    }

}
