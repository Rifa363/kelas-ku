<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_with_valid_kode_kelas(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Test User',
            'nim' => '1234567890',
            'email' => 'test@example.com',
            'no_hp' => '08123456789',
            'angkatan' => '2026',
            'password' => 'password',
            'password_confirmation' => 'password',
            'kode_kelas' => config('app.kelas_kode'),
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_new_users_cannot_register_with_invalid_kode_kelas(): void
    {
        $response = $this->post('/register', [
            'nama' => 'Test User',
            'nim' => '1234567890',
            'email' => 'test@example.com',
            'no_hp' => '08123456789',
            'angkatan' => '2026',
            'password' => 'password',
            'password_confirmation' => 'password',
            'kode_kelas' => 'SALAH',
        ]);

        $response->assertSessionHasErrors('kode_kelas');
        $this->assertGuest();
    }
}
