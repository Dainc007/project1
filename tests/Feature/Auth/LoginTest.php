<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_user_can_login_by_email(): void
    {
        $response = $this->post('/login', [
            'login' => $this->user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    }

    public function test_user_can_login_by_name(): void
    {
        $response = $this->post('/login', [
            'login' => $this->user->name,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    }

    public function test_validation_invalid_login_error(): void
    {
        $response = $this->post('/login', [
            'login' => 'invalid_login',
            'password' => 'password',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors(['login']);
    }

    public function test_validation_invalid_empty_login_error(): void
    {
        $response = $this->post('/login', [
            'login' => 'invalid_login',
            'password' => 'password',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors(['login']);
    }

    public function test_validation_invalid_password_error(): void
    {
        $response = $this->post('/login', [
            'login' => $this->user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors(['login']);
    }

    public function test_validation_empty_password_error(): void
    {
        $response = $this->post('/login', [
            'login' => $this->user->email,
            'password' => '',
        ]);

        $this->assertGuest();

        $response->assertSessionHasErrors(['password']);
    }
}
