<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_admin_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->get('/admin/posts')->assertRedirect(route('admin.login'));
    }

    public function test_registration_routes_do_not_exist(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register')->assertNotFound();
    }

    public function test_admin_can_sign_in_and_reach_the_dashboard(): void
    {
        $user = User::factory()->create(['password' => 'rahasia123']);

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'rahasia123',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('admin.dashboard'))->assertOk()->assertSee('Dashboard');
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $user = User::factory()->create();

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'kata-sandi-salah',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_can_sign_out(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.logout'))->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }
}
