<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\User;
use App\Services\IdentityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class IdentitySettingsTest extends TestCase
{
    use RefreshDatabase;

    private Branch $rootBranch;
    private Branch $subBranch;
    private User $superAdmin;
    private User $ketua;
    private User $staff;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create root branch (parent_id is null - DPP)
        $this->rootBranch = Branch::create([
            'tier' => 'dpp',
            'code' => 'DPP-PUSAAT',
            'name' => 'Dewan Pimpinan Pusat',
            'identity_settings' => [
                'party_name'      => 'Partai Rekonsiliasi',
                'logo_party_path' => 'logos/party/central.png',
                'address'         => 'Gedung Juang, Jakarta',
                'phone'           => '021-111111',
                'email'           => 'dpp@party.org'
            ],
            'is_active' => true,
        ]);

        // 2. Create sub branch (DPD West Java)
        $this->subBranch = Branch::create([
            'parent_id' => $this->rootBranch->id,
            'tier' => 'dpd',
            'code' => 'DPD-JABAR',
            'name' => 'DPD Jawa Barat',
            'is_active' => true,
        ]);

        // 3. Create users
        $this->superAdmin = User::factory()->create([
            'role' => 'super_admin',
            'status' => 'active'
        ]);

        $this->ketua = User::factory()->create([
            'branch_id' => $this->subBranch->id,
            'role' => 'ketua',
            'status' => 'active'
        ]);

        $this->staff = User::factory()->create([
            'branch_id' => $this->subBranch->id,
            'role' => 'staff',
            'status' => 'active'
        ]);
    }

    /** @test */
    public function test_identity_service_resolves_fallback_correctly()
    {
        // Fetch settings for the sub-branch which has null identity_settings in database
        $settings = IdentityService::getSettingsForBranch($this->subBranch->id);

        // Should fall back to root branch settings
        $this->assertEquals('Partai Rekonsiliasi', $settings['party_name']);
        $this->assertEquals('DPD Jawa Barat', $settings['branch_display_name']); // fallback to branch.name
        $this->assertEquals('logos/party/central.png', $settings['logo_party_path']);
        $this->assertEquals('Gedung Juang, Jakarta', $settings['address']);
        $this->assertEquals('021-111111', $settings['phone']);
        $this->assertEquals('dpp@party.org', $settings['email']);
    }

    /** @test */
    public function test_ketua_can_update_their_own_branch_identity_settings()
    {
        Storage::fake('public');

        $this->actingAs($this->ketua);

        $response = $this->postJson("/api/branches/{$this->subBranch->id}/identity", [
            'branch_display_name' => 'DPD Jabar Gemilang',
            'address'             => 'Jl. Asia Afrika No. 45, Bandung',
            'phone'               => '022-444444',
            'email'               => 'jabar@party.org',
            'logo_branch'         => UploadedFile::fake()->image('jabar-logo.png'),
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        // Check database
        $this->assertDatabaseHas('branches', [
            'id' => $this->subBranch->id,
            'name' => 'DPD Jawa Barat', // base name remains unchanged
        ]);

        $updatedBranch = $this->subBranch->fresh();
        $this->assertEquals('DPD Jabar Gemilang', $updatedBranch->identity_settings['branch_display_name']);
        $this->assertEquals('Jl. Asia Afrika No. 45, Bandung', $updatedBranch->identity_settings['address']);
        $this->assertNotNull($updatedBranch->identity_settings['logo_branch_path']);

        // Check file exists in fake storage
        Storage::disk('public')->assertExists($updatedBranch->identity_settings['logo_branch_path']);
    }

    /** @test */
    public function test_staff_cannot_update_branch_identity_settings()
    {
        $this->actingAs($this->staff);

        $response = $this->postJson("/api/branches/{$this->subBranch->id}/identity", [
            'branch_display_name' => 'DPD Hack',
        ]);

        $response->assertStatus(403);
    }
}
