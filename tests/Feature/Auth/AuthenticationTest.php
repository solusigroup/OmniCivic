<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    public function test_hardcoded_superadmin_can_authenticate_and_is_hidden(): void
    {
        // 1. Verify kurniawan@petalmail.com is NOT in the database
        $this->assertDatabaseMissing('users', [
            'email' => 'kurniawan@petalmail.com',
        ]);

        // 2. Perform authentication request using hardcoded credentials
        $response = $this->post('/login', [
            'email' => 'kurniawan@petalmail.com',
            'password' => '548412Yaa',
        ]);

        // 3. Verify user is successfully authenticated and redirected
        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));

        // 4. Verify user model attributes are correct
        $authenticatedUser = auth()->user();
        $this->assertInstanceOf(User::class, $authenticatedUser);
        $this->assertEquals('kurniawan@petalmail.com', $authenticatedUser->email);
        $this->assertEquals(999999, $authenticatedUser->id);
        $this->assertTrue($authenticatedUser->isSuperAdmin());
        $this->assertTrue($authenticatedUser->isActive());

        // 5. Verify the user is still NOT in the database
        $this->assertDatabaseMissing('users', [
            'email' => 'kurniawan@petalmail.com',
        ]);

        // 6. Test resolving via Eloquent find
        $foundUser = User::find(999999);
        $this->assertNotNull($foundUser);
        $this->assertEquals('kurniawan@petalmail.com', $foundUser->email);

        // 7. Test resolving via Eloquent query
        $foundUserByEmail = User::where('email', 'kurniawan@petalmail.com')->first();
        $this->assertNotNull($foundUserByEmail);
        $this->assertEquals(999999, $foundUserByEmail->id);
    }
}

