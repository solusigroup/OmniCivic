<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\ChartOfAccount;
use App\Models\Division;
use App\Models\FundSource;
use App\Models\Journal;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CashTransactionTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Branch $branch;
    private ChartOfAccount $cashAccount;
    private ChartOfAccount $bankAccount;
    private ChartOfAccount $revenueAccount;
    private ChartOfAccount $expenseAccount;
    private Program $program;
    private Division $division;
    private FundSource $fundSource;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create a branch first
        $this->branch = Branch::create([
            'tier' => 'dpp',
            'code' => 'DPP-001',
            'name' => 'DPP Pusat Jakarta',
            'is_active' => true,
        ]);

        // 2. Create the staff user belonging to this branch
        $this->user = User::factory()->create([
            'branch_id' => $this->branch->id,
            'role' => 'staff',
            'status' => 'active',
        ]);
        $this->actingAs($this->user);

        // Create Chart of Accounts
        $this->cashAccount = ChartOfAccount::create([
            'code' => '1-1001',
            'name' => 'Kas Pusat',
            'type' => 'asset',
            'restriction_type' => 'unrestricted',
            'is_cash_or_bank' => true,
            'normal_balance' => 'debit',
        ]);

        $this->bankAccount = ChartOfAccount::create([
            'code' => '1-1002',
            'name' => 'Bank Mandiri DPP',
            'type' => 'asset',
            'restriction_type' => 'unrestricted',
            'is_cash_or_bank' => true,
            'normal_balance' => 'debit',
        ]);

        $this->revenueAccount = ChartOfAccount::create([
            'code' => '4-1001',
            'name' => 'Sumbangan Anggota',
            'type' => 'revenue',
            'restriction_type' => 'unrestricted',
            'is_cash_or_bank' => false,
            'normal_balance' => 'credit',
        ]);

        $this->expenseAccount = ChartOfAccount::create([
            'code' => '5-1001',
            'name' => 'Beban Kampanye',
            'type' => 'expense',
            'restriction_type' => 'unrestricted',
            'is_cash_or_bank' => false,
            'normal_balance' => 'debit',
        ]);

        // Create Program, Division, Fund Source
        $this->program = Program::create([
            'code' => 'PRG-001',
            'name' => 'Bakti Sosial Ramadhan',
        ]);

        $this->division = Division::create([
            'code' => 'DIV-HUMAS',
            'name' => 'Divisi Hubungan Masyarakat',
        ]);

        $this->fundSource = FundSource::create([
            'code' => 'FND-MEMBER',
            'name' => 'Iuran Wajib Anggota',
            'type' => 'member_contribution',
        ]);
    }

    /** @test */
    public function test_it_can_create_a_cash_in_transaction()
    {
        $response = $this->postJson('/api/transactions/cash-in', [
            'branch_id' => $this->branch->id,
            'transaction_date' => '2026-06-26',
            'description' => 'Penerimaan Iuran Anggota Perdana',
            'cash_account_id' => $this->cashAccount->id,
            'revenue_account_id' => $this->revenueAccount->id,
            'amount' => 5000000.00,
            'program_id' => $this->program->id,
            'division_id' => $this->division->id,
            'fund_source_id' => $this->fundSource->id,
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.transaction_type', 'cash_in');
        $response->assertJsonPath('data.status', 'draft');

        $journalId = $response->json('data.id');

        $this->assertDatabaseHas('journals', [
            'id' => $journalId,
            'transaction_type' => 'cash_in',
            'status' => 'draft',
            'created_by' => $this->user->id,
        ]);

        $this->assertDatabaseHas('journal_details', [
            'journal_id' => $journalId,
            'account_id' => $this->cashAccount->id,
            'debit' => 5000000.00,
            'credit' => 0.00,
            'program_id' => $this->program->id,
            'division_id' => $this->division->id,
            'fund_source_id' => $this->fundSource->id,
        ]);

        $this->assertDatabaseHas('journal_details', [
            'journal_id' => $journalId,
            'account_id' => $this->revenueAccount->id,
            'debit' => 0.00,
            'credit' => 5000000.00,
            'program_id' => $this->program->id,
            'division_id' => $this->division->id,
            'fund_source_id' => $this->fundSource->id,
        ]);
    }

    /** @test */
    public function test_it_can_create_a_cash_out_transaction()
    {
        $response = $this->postJson('/api/transactions/cash-out', [
            'branch_id' => $this->branch->id,
            'transaction_date' => '2026-06-26',
            'description' => 'Pembelian Atribut Baksos',
            'expense_account_id' => $this->expenseAccount->id,
            'cash_account_id' => $this->cashAccount->id,
            'amount' => 1250000.00,
            'program_id' => $this->program->id,
            'division_id' => $this->division->id,
            'fund_source_id' => $this->fundSource->id,
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.transaction_type', 'cash_out');

        $journalId = $response->json('data.id');

        $this->assertDatabaseHas('journal_details', [
            'journal_id' => $journalId,
            'account_id' => $this->expenseAccount->id,
            'debit' => 1250000.00,
            'credit' => 0.00,
        ]);

        $this->assertDatabaseHas('journal_details', [
            'journal_id' => $journalId,
            'account_id' => $this->cashAccount->id,
            'debit' => 0.00,
            'credit' => 1250000.00,
        ]);
    }

    /** @test */
    public function test_it_can_create_a_transfer_transaction()
    {
        $response = $this->postJson('/api/transactions/transfer', [
            'branch_id' => $this->branch->id,
            'transaction_date' => '2026-06-26',
            'description' => 'Setor tunai ke Bank',
            'destination_account_id' => $this->bankAccount->id,
            'origin_account_id' => $this->cashAccount->id,
            'amount' => 2000000.00,
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('success', true);
        $response->assertJsonPath('data.transaction_type', 'transfer');

        $journalId = $response->json('data.id');

        $this->assertDatabaseHas('journal_details', [
            'journal_id' => $journalId,
            'account_id' => $this->bankAccount->id,
            'debit' => 2000000.00,
            'credit' => 0.00,
        ]);

        $this->assertDatabaseHas('journal_details', [
            'journal_id' => $journalId,
            'account_id' => $this->cashAccount->id,
            'debit' => 0.00,
            'credit' => 2000000.00,
        ]);
    }

    /** @test */
    public function test_transfer_destination_and_origin_must_be_different()
    {
        $response = $this->postJson('/api/transactions/transfer', [
            'branch_id' => $this->branch->id,
            'transaction_date' => '2026-06-26',
            'description' => 'Setor tunai ke Bank sendiri',
            'destination_account_id' => $this->cashAccount->id,
            'origin_account_id' => $this->cashAccount->id,
            'amount' => 2000000.00,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['destination_account_id']);
    }

    /** @test */
    public function test_it_enforces_the_state_machine_approval_workflow()
    {
        // 1. Create a draft journal directly
        $journal = Journal::create([
            'branch_id' => $this->branch->id,
            'transaction_type' => 'cash_in',
            'transaction_date' => '2026-06-26',
            'reference_number' => 'CI-20260626-9999',
            'status' => 'draft',
            'created_by' => $this->user->id,
        ]);

        // 2. Draft to approved is invalid transition (workflow check) -> returns 422
        $response = $this->patchJson("/api/transactions/{$journal->id}/status", [
            'status' => 'approved',
        ]);
        $response->assertStatus(422);

        // 2b. Draft to reviewed is valid transition, but unauthorized for staff (role check) -> returns 403
        $response = $this->patchJson("/api/transactions/{$journal->id}/status", [
            'status' => 'reviewed',
        ]);
        $response->assertStatus(403);

        // 3. Create a Bendahara user
        $bendahara = User::factory()->create([
            'branch_id' => $this->branch->id,
            'role' => 'bendahara',
            'status' => 'active',
        ]);

        // Act as bendahara
        $this->actingAs($bendahara);

        // 4. Bendahara to approved is invalid (requires Ketua)
        $response = $this->patchJson("/api/transactions/{$journal->id}/status", [
            'status' => 'approved',
        ]);
        $response->assertStatus(422); // Invalid transition (draft -> approved)

        // 5. Bendahara to reviewed is valid
        $response = $this->patchJson("/api/transactions/{$journal->id}/status", [
            'status' => 'reviewed',
        ]);
        $response->assertStatus(200);
        $this->assertEquals('reviewed', $response->json('data.status'));
        $this->assertEquals($bendahara->id, $response->json('data.reviewed_by'));
        $this->assertNotNull($response->json('data.reviewed_at'));

        // 6. Create a Ketua user
        $ketua = User::factory()->create([
            'branch_id' => $this->branch->id,
            'role' => 'ketua',
            'status' => 'active',
        ]);

        // Act as ketua
        $this->actingAs($ketua);

        // 7. Ketua to draft is invalid (workflow restriction)
        $response = $this->patchJson("/api/transactions/{$journal->id}/status", [
            'status' => 'draft',
        ]);
        $response->assertStatus(422);

        // 8. Ketua to approved is valid
        $response = $this->patchJson("/api/transactions/{$journal->id}/status", [
            'status' => 'approved',
        ]);
        $response->assertStatus(200);
        $this->assertEquals('approved', $response->json('data.status'));
        $this->assertEquals($ketua->id, $response->json('data.approved_by'));
        $this->assertNotNull($response->json('data.approved_at'));
    }

    /** @test */
    public function test_only_approved_journals_are_included_in_the_approved_scope()
    {
        // Create draft journal
        Journal::create([
            'branch_id' => $this->branch->id,
            'transaction_type' => 'cash_in',
            'transaction_date' => '2026-06-26',
            'reference_number' => 'CI-20260626-0001',
            'status' => 'draft',
            'created_by' => $this->user->id,
        ]);

        // Create approved journal
        Journal::create([
            'branch_id' => $this->branch->id,
            'transaction_type' => 'cash_in',
            'transaction_date' => '2026-06-26',
            'reference_number' => 'CI-20260626-0002',
            'status' => 'approved',
            'created_by' => $this->user->id,
        ]);

        $approvedJournals = Journal::approved()->get();

        $this->assertCount(1, $approvedJournals);
        $this->assertEquals('CI-20260626-0002', $approvedJournals->first()->reference_number);
    }
}
