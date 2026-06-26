<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\ChartOfAccount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class COAManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $staff;
    private Branch $branch;

    protected function setUp(): void
    {
        parent::setUp();

        $this->branch = Branch::create([
            'tier' => 'dpp',
            'code' => 'DPP-001',
            'name' => 'DPP Pusat Jakarta',
            'is_active' => true,
        ]);

        $this->admin = User::factory()->create([
            'branch_id' => $this->branch->id,
            'role' => 'super_admin',
            'status' => 'active',
        ]);

        $this->staff = User::factory()->create([
            'branch_id' => $this->branch->id,
            'role' => 'staff',
            'status' => 'active',
        ]);
    }

    public function test_unauthorized_user_cannot_access_coa_management_endpoints()
    {
        $this->actingAs($this->staff);

        $response = $this->post(route('settings.coa.store'), [
            'code' => '104',
            'name' => 'Piutang Khusus',
            'type' => 'asset',
            'restriction_type' => 'unrestricted',
            'normal_balance' => 'debit',
            'beginning_balance' => 1500000.00,
        ]);

        $response->assertStatus(403);
    }

    public function test_authorized_user_can_create_coa_with_beginning_balance()
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('settings.coa.store'), [
            'code' => '105',
            'name' => 'Piutang Khusus',
            'type' => 'asset',
            'restriction_type' => 'unrestricted',
            'normal_balance' => 'debit',
            'beginning_balance' => 1500000.00,
            'is_cash_or_bank' => 0,
        ]);

        $response->assertRedirect(route('settings.coa.index'));
        $this->assertDatabaseHas('chart_of_accounts', [
            'code' => '105',
            'name' => 'Piutang Khusus',
            'beginning_balance' => 1500000.00,
        ]);
    }

    public function test_authorized_user_can_update_coa()
    {
        $this->actingAs($this->admin);

        $coa = ChartOfAccount::create([
            'code' => '106',
            'name' => 'Persediaan ATK',
            'type' => 'asset',
            'restriction_type' => 'unrestricted',
            'normal_balance' => 'debit',
            'beginning_balance' => 500000.00,
        ]);

        $response = $this->put(route('settings.coa.update', $coa), [
            'code' => '106',
            'name' => 'Persediaan ATK Kantor',
            'type' => 'asset',
            'restriction_type' => 'unrestricted',
            'normal_balance' => 'debit',
            'beginning_balance' => 750000.00,
        ]);

        $response->assertRedirect(route('settings.coa.index'));
        $this->assertDatabaseHas('chart_of_accounts', [
            'id' => $coa->id,
            'name' => 'Persediaan ATK Kantor',
            'beginning_balance' => 750000.00,
        ]);
    }

    public function test_authorized_user_can_delete_unused_coa()
    {
        $this->actingAs($this->admin);

        $coa = ChartOfAccount::create([
            'code' => '107',
            'name' => 'Akun Sampah',
            'type' => 'asset',
            'restriction_type' => 'unrestricted',
            'normal_balance' => 'debit',
            'beginning_balance' => 0.00,
        ]);

        $response = $this->delete(route('settings.coa.destroy', $coa));

        $response->assertRedirect(route('settings.coa.index'));
        $this->assertSoftDeleted('chart_of_accounts', [
            'id' => $coa->id,
        ]);
    }

    public function test_authorized_user_can_toggle_coa_active_status()
    {
        $this->actingAs($this->admin);

        $coa = ChartOfAccount::create([
            'code' => '108',
            'name' => 'Akun Sementara',
            'type' => 'asset',
            'restriction_type' => 'unrestricted',
            'normal_balance' => 'debit',
            'beginning_balance' => 0.00,
            'is_active' => true,
        ]);

        $response = $this->post(route('settings.coa.toggle', $coa));

        $response->assertRedirect(route('settings.coa.index'));
        $this->assertDatabaseHas('chart_of_accounts', [
            'id' => $coa->id,
            'is_active' => false,
        ]);
    }

    public function test_staff_can_store_non_cash_journal_transaction()
    {
        $this->actingAs($this->staff);

        $debitAcc = ChartOfAccount::create([
            'code' => '504',
            'name' => 'Beban Lain-Lain',
            'type' => 'expense',
            'restriction_type' => 'unrestricted',
            'normal_balance' => 'debit',
        ]);

        $creditAcc = ChartOfAccount::create([
            'code' => '202',
            'name' => 'Utang Jasa Pajak',
            'type' => 'liability',
            'restriction_type' => 'unrestricted',
            'normal_balance' => 'credit',
        ]);

        $response = $this->post(route('transactions.non-cash'), [
            'transaction_date' => '2026-06-26',
            'description' => 'Penyesuaian biaya jasa profesional terutang',
            'debit_account_id' => $debitAcc->id,
            'credit_account_id' => $creditAcc->id,
            'amount' => 3500000.00,
        ]);

        $response->assertRedirect(route('transactions.index'));
        
        $this->assertDatabaseHas('journals', [
            'transaction_type' => 'non_cash',
            'description' => 'Penyesuaian biaya jasa profesional terutang',
            'status' => 'draft',
        ]);
    }
}
