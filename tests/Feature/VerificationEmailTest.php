<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VerificationEmailTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_method()
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->get(route('verification.notice'))
            ->assertViewIs('verify-email.verifyEmails');
    }
}
