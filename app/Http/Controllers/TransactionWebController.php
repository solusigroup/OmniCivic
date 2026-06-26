<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\JournalDetail;
use App\Models\ChartOfAccount;
use App\Models\Program;
use App\Models\Division;
use App\Models\FundSource;
use App\Models\Branch;
use App\Services\IdentityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TransactionWebController extends Controller
{
    /**
     * Helper to verify if the authenticated user has access to a given branch.
     */
    private function verifyBranchAccess(int $branchId): void
    {
        $user = Auth::user();
        if ($user->isSuperAdmin()) {
            return;
        }
        if ((int) $user->branch_id !== $branchId) {
            abort(403, 'Akses cabang ditolak. Anda tidak memiliki akses ke cabang ini.');
        }
    }

    /**
     * Display a listing of transactions and input forms.
     */
    public function index()
    {
        $user = Auth::user();
        $branchId = $user->branch_id;
        
        $settings = IdentityService::getSettingsForBranch($branchId);

        // Fetch journals scoped by branch
        $journalsQuery = Journal::with(['details.account', 'creator', 'reviewer', 'approver']);
        if ($user->role !== 'super_admin') {
            $journalsQuery->where('branch_id', $branchId);
        }
        $journals = $journalsQuery->latest()->paginate(10);

        // Fetch Chart of Accounts for forms
        $cashAccounts = ChartOfAccount::where('is_cash_or_bank', true)->where('is_active', true)->get();
        $revenueAccounts = ChartOfAccount::where('type', 'revenue')->where('is_active', true)->get();
        $expenseAccounts = ChartOfAccount::where('type', 'expense')->where('is_active', true)->get();
        $allAccounts = ChartOfAccount::where('is_active', true)->orderBy('code')->get();
        
        // Fetch dimensional tags
        $programs = Program::where('is_active', true)->get();
        $divisions = Division::where('is_active', true)->get();
        $fundSources = FundSource::where('is_active', true)->get();

        return view('journals.index', [
            'settings' => $settings,
            'journals' => $journals,
            'cashAccounts' => $cashAccounts,
            'revenueAccounts' => $revenueAccounts,
            'expenseAccounts' => $expenseAccounts,
            'allAccounts' => $allAccounts,
            'programs' => $programs,
            'divisions' => $divisions,
            'fundSources' => $fundSources,
            'role' => $user->role,
            'branchId' => $branchId,
        ]);
    }

    /**
     * Store a Cash In transaction.
     */
    public function storeCashIn(Request $request)
    {
        if (!Gate::allows('create', Journal::class)) {
            abort(403, 'Hanya operator Staff yang diperbolehkan membuat transaksi.');
        }

        $validated = $request->validate([
            'transaction_date'   => ['required', 'date'],
            'description'        => ['required', 'string', 'max:500'],
            'cash_account_id'    => ['required', 'exists:chart_of_accounts,id'],
            'revenue_account_id' => ['required', 'exists:chart_of_accounts,id'],
            'amount'             => ['required', 'numeric', 'min:0.01'],
            'program_id'         => ['nullable', 'exists:programs,id'],
            'division_id'        => ['nullable', 'exists:divisions,id'],
            'fund_source_id'     => ['nullable', 'exists:fund_sources,id'],
        ]);

        $user = Auth::user();
        $branchId = $user->branch_id;

        DB::transaction(function () use ($validated, $branchId, $user) {
            $refNumber = $this->generateReferenceNumber('CI', $branchId);

            $journal = Journal::create([
                'reference_number' => $refNumber,
                'branch_id' => $branchId,
                'transaction_date' => $validated['transaction_date'],
                'description' => $validated['description'],
                'status' => 'draft',
                'transaction_type' => 'cash_in',
                'created_by' => $user->id,
            ]);

            // Debit Cash/Bank
            JournalDetail::create([
                'journal_id' => $journal->id,
                'account_id' => $validated['cash_account_id'],
                'debit' => $validated['amount'],
                'credit' => 0,
                'program_id' => $validated['program_id'] ?? null,
                'division_id' => $validated['division_id'] ?? null,
                'fund_source_id' => $validated['fund_source_id'] ?? null,
            ]);

            // Credit Revenue
            JournalDetail::create([
                'journal_id' => $journal->id,
                'account_id' => $validated['revenue_account_id'],
                'debit' => 0,
                'credit' => $validated['amount'],
                'program_id' => $validated['program_id'] ?? null,
                'division_id' => $validated['division_id'] ?? null,
                'fund_source_id' => $validated['fund_source_id'] ?? null,
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi Kas Masuk berhasil disimpan sebagai draf.');
    }

    /**
     * Store a Cash Out transaction.
     */
    public function storeCashOut(Request $request)
    {
        if (!Gate::allows('create', Journal::class)) {
            abort(403, 'Hanya operator Staff yang diperbolehkan membuat transaksi.');
        }

        $validated = $request->validate([
            'transaction_date'   => ['required', 'date'],
            'description'        => ['required', 'string', 'max:500'],
            'cash_account_id'    => ['required', 'exists:chart_of_accounts,id'],
            'expense_account_id' => ['required', 'exists:chart_of_accounts,id'],
            'amount'             => ['required', 'numeric', 'min:0.01'],
            'program_id'         => ['nullable', 'exists:programs,id'],
            'division_id'        => ['nullable', 'exists:divisions,id'],
            'fund_source_id'     => ['nullable', 'exists:fund_sources,id'],
        ]);

        $user = Auth::user();
        $branchId = $user->branch_id;

        DB::transaction(function () use ($validated, $branchId, $user) {
            $refNumber = $this->generateReferenceNumber('CO', $branchId);

            $journal = Journal::create([
                'reference_number' => $refNumber,
                'branch_id' => $branchId,
                'transaction_date' => $validated['transaction_date'],
                'description' => $validated['description'],
                'status' => 'draft',
                'transaction_type' => 'cash_out',
                'created_by' => $user->id,
            ]);

            // Debit Expense
            JournalDetail::create([
                'journal_id' => $journal->id,
                'account_id' => $validated['expense_account_id'],
                'debit' => $validated['amount'],
                'credit' => 0,
                'program_id' => $validated['program_id'] ?? null,
                'division_id' => $validated['division_id'] ?? null,
                'fund_source_id' => $validated['fund_source_id'] ?? null,
            ]);

            // Credit Cash/Bank
            JournalDetail::create([
                'journal_id' => $journal->id,
                'account_id' => $validated['cash_account_id'],
                'debit' => 0,
                'credit' => $validated['amount'],
                'program_id' => $validated['program_id'] ?? null,
                'division_id' => $validated['division_id'] ?? null,
                'fund_source_id' => $validated['fund_source_id'] ?? null,
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi Kas Keluar berhasil disimpan sebagai draf.');
    }

    /**
     * Store a Transfer transaction.
     */
    public function storeTransfer(Request $request)
    {
        if (!Gate::allows('create', Journal::class)) {
            abort(403, 'Hanya operator Staff yang diperbolehkan membuat transaksi.');
        }

        $validated = $request->validate([
            'transaction_date'          => ['required', 'date'],
            'description'               => ['required', 'string', 'max:500'],
            'origin_cash_account_id'      => ['required', 'exists:chart_of_accounts,id', 'different:destination_cash_account_id'],
            'destination_cash_account_id' => ['required', 'exists:chart_of_accounts,id'],
            'amount'                    => ['required', 'numeric', 'min:0.01'],
        ]);

        $user = Auth::user();
        $branchId = $user->branch_id;

        DB::transaction(function () use ($validated, $branchId, $user) {
            $refNumber = $this->generateReferenceNumber('TR', $branchId);

            $journal = Journal::create([
                'reference_number' => $refNumber,
                'branch_id' => $branchId,
                'transaction_date' => $validated['transaction_date'],
                'description' => $validated['description'],
                'status' => 'draft',
                'transaction_type' => 'transfer',
                'created_by' => $user->id,
            ]);

            // Debit Destination Cash/Bank
            JournalDetail::create([
                'journal_id' => $journal->id,
                'account_id' => $validated['destination_cash_account_id'],
                'debit' => $validated['amount'],
                'credit' => 0,
            ]);

            // Credit Origin Cash/Bank
            JournalDetail::create([
                'journal_id' => $journal->id,
                'account_id' => $validated['origin_cash_account_id'],
                'debit' => 0,
                'credit' => $validated['amount'],
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi Transfer Kas berhasil disimpan sebagai draf.');
    }

    /**
     * Store a Non Cash transaction.
     */
    public function storeNonCash(Request $request)
    {
        if (!Gate::allows('create', Journal::class)) {
            abort(403, 'Hanya operator Staff yang diperbolehkan membuat transaksi.');
        }

        $validated = $request->validate([
            'transaction_date'  => ['required', 'date'],
            'description'       => ['required', 'string', 'max:500'],
            'debit_account_id'  => ['required', 'exists:chart_of_accounts,id'],
            'credit_account_id' => ['required', 'exists:chart_of_accounts,id', 'different:debit_account_id'],
            'amount'            => ['required', 'numeric', 'min:0.01'],
            'program_id'        => ['nullable', 'exists:programs,id'],
            'division_id'       => ['nullable', 'exists:divisions,id'],
            'fund_source_id'    => ['nullable', 'exists:fund_sources,id'],
        ]);

        $user = Auth::user();
        $branchId = $user->branch_id;

        DB::transaction(function () use ($validated, $branchId, $user) {
            $refNumber = $this->generateReferenceNumber('NC', $branchId);

            $journal = Journal::create([
                'reference_number' => $refNumber,
                'branch_id' => $branchId,
                'transaction_date' => $validated['transaction_date'],
                'description' => $validated['description'],
                'status' => 'draft',
                'transaction_type' => 'non_cash',
                'created_by' => $user->id,
            ]);

            // Debit account
            JournalDetail::create([
                'journal_id' => $journal->id,
                'account_id' => $validated['debit_account_id'],
                'debit' => $validated['amount'],
                'credit' => 0,
                'program_id' => $validated['program_id'] ?? null,
                'division_id' => $validated['division_id'] ?? null,
                'fund_source_id' => $validated['fund_source_id'] ?? null,
            ]);

            // Credit account
            JournalDetail::create([
                'journal_id' => $journal->id,
                'account_id' => $validated['credit_account_id'],
                'debit' => 0,
                'credit' => $validated['amount'],
                'program_id' => $validated['program_id'] ?? null,
                'division_id' => $validated['division_id'] ?? null,
                'fund_source_id' => $validated['fund_source_id'] ?? null,
            ]);
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi Jurnal Non-Kas berhasil disimpan sebagai draf.');
    }

    /**
     * Generate reference numbers based on type and branch.
     */
    private function generateReferenceNumber(string $prefix, int $branchId): string
    {
        $branch = Branch::find($branchId);
        $branchCode = $branch ? $branch->code : 'DPP';
        
        $count = Journal::where('branch_id', $branchId)
            ->where('reference_number', 'like', "$prefix-$branchCode-%")
            ->count();

        $seq = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        return "$prefix-$branchCode-$seq";
    }
}
