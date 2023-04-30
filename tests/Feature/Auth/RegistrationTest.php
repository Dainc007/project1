<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseCount(User::class, 1);

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_validation_empty_name_error(): void
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $this->assertDatabaseEmpty(User::class);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_validation_too_long_name_error(): void
    {
        $response = $this->post('/register', [
            'name' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $this->assertDatabaseEmpty(User::class);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_validation_not_unique_name_error(): void
    {
        User::factory()->create([
            'name' => 'BestName'
        ]);

        $response = $this->post('/register', [
            'name' => 'BestName',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $this->assertDatabaseCount(User::class, 1);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_validation_empty_email_error(): void
    {
        $response = $this->post('/register', [
            'name' => 'BestName',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $this->assertDatabaseEmpty(User::class);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_validation_invalid_email_error(): void
    {
        $response = $this->post('/register', [
            'name' => 'BestName',
            'email' => 'invalid_email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $this->assertDatabaseEmpty(User::class);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_validation_not_unique_email_error(): void
    {
        User::factory()->create([
            'email' => 'some_email@menago.com',
        ]);

        $response = $this->post('/register', [
            'name' => 'BestName',
            'email' => 'some_email@menago.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $this->assertDatabaseCount(User::class, 1);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_validation_empty_password_error(): void
    {
         $response = $this->post('/register', [
            'name' => 'BestName',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $this->assertDatabaseEmpty(User::class);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_validation_invalid_confirmation_password_error(): void
    {
         $response = $this->post('/register', [
            'name' => 'BestName',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'different_password',
        ]);

        $this->assertGuest();
        $this->assertDatabaseEmpty(User::class);

        $response->assertSessionHasErrors(['password']);
    }
}
