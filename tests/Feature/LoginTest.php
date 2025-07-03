<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
// use Tests\TestCase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Laravel\Socialite\Contracts\User as ProviderUser;


// use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function tc1_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'password' => 'password123'
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function tc2_login_with_invalid_credentials()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function tc3_login_with_empty_fields()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    /** @test */
    public function tc4_password_field_is_hidden_on_login_page()
    {
        $response = $this->get('/login');
        $response->assertSee('<input type="password"', false);
    }
    // Forgot password for later on, not now.
    /** @test */
    // public function tc6_forgot_password_link_exists()
    // {
    //     $response = $this->get('/login');
    //     $response->assertSee('Forgot Your Password?');
    // }

    /** @test */
    public function tc7_remember_me_functionality()
    {
        $user = User::factory()->create([
            'email' => 'tc7_remember_me_email@email',
            'password' => 'password123'
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
            'remember' => 'on',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
        // Note: Laravel does not simulate "closing the browser" in tests
    }

    // For later
    /** @test */
    // public function tc8_google_login_button_exists()
    // {
    //     $response = $this->get('/login');
    //     $response->assertSee('Login with Google');
    // }

    /** @test */
    public function tc9_register_link_exists()
    {
        $response = $this->get('/login');
        $response->assertSee("Register now!");
    }

    /** @test */
    public function tc10_register_asvendor_link_exists()
    {
        $response = $this->get('/login');
        $response->assertSee("Join Eatwell as a <u>vendor!</u>", false);
    }

    /** @test */
    public function tc10_google_redirect_route()
    {
        $response = $this->get('/auth/google/redirect');
        $response->assertRedirect(); // Akan redirect ke Google
    }


}
