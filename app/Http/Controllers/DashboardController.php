<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\JournalDetail;
use App\Models\Program;
use App\Services\IdentityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display the dashboard home with metrics and branch transactions.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ensure user has a branch. Default to root if missing.
        $branchId = $user->branch_id;
        
        // Retrieve identity settings using the service
        $settings = IdentityService::getSettingsForBranch($branchId);

        // Fetch journals based on branch and role permissions
        $journalsQuery = Journal::with(['details.account', 'creator', 'reviewer', 'approver']);
        
        if ($user->role !== 'super_admin') {
            $journalsQuery->where('branch_id', $branchId);
        }
        
        $recentJournals = $journalsQuery->latest()->take(10)->get();

        // Calculate Metrics
        // 1. Kas Konsolidasi (Debit - Credit for all Approved Cash/Bank account details)
        $approvedJournalIds = Journal::where('status', 'approved');
        if ($user->role !== 'super_admin') {
            $approvedJournalIds->where('branch_id', $branchId);
        }
        $approvedJournalIds = $approvedJournalIds->pluck('id');

        // Fetch cash/bank accounts to include their beginning balance
        $cashAccounts = \App\Models\ChartOfAccount::where('is_cash_or_bank', true)->get();
        $totalCash = 0;
        foreach ($cashAccounts as $acc) {
            $totalCash += (float) $acc->beginning_balance;
        }

        $cashBankDetails = JournalDetail::whereIn('journal_id', $approvedJournalIds)
            ->whereHas('account', function ($query) {
                $query->where('is_cash_or_bank', true);
            })->get();

        foreach ($cashBankDetails as $detail) {
            $totalCash += ($detail->debit - $detail->credit);
        }

        // 2. Sumbangan Terikat (Credit - Debit for all Approved revenue details under restricted accounts)
        $restrictedDetails = JournalDetail::whereIn('journal_id', $approvedJournalIds)
            ->whereHas('account', function ($query) {
                $query->whereIn('restriction_type', ['temporarily_restricted', 'permanently_restricted']);
            })->get();

        $totalRestricted = 0;
        foreach ($restrictedDetails as $detail) {
            $totalRestricted += ($detail->credit - $detail->debit);
        }

        // 3. Persetujuan Pending
        $pendingQuery = Journal::whereIn('status', ['draft', 'reviewed']);
        if ($user->role !== 'super_admin') {
            $pendingQuery->where('branch_id', $branchId);
        }
        $pendingCount = $pendingQuery->count();

        // 4. Program Realization (P-01 - Bakti Sosial Ramadhan expenses vs budget Rp 30,000,000)
        $progBaksos = Program::where('code', 'P-01')->first();
        $baksosExpenses = 0;
        if ($progBaksos) {
            $baksosExpenses = JournalDetail::whereIn('journal_id', $approvedJournalIds)
                ->where('program_id', $progBaksos->id)
                ->whereHas('account', function ($query) {
                    $query->where('type', 'expense');
                })
                ->sum('debit');
        }
        
        $baksosBudget = 30000000.00;
        $baksosProgress = $baksosBudget > 0 ? min(round(($baksosExpenses / $baksosBudget) * 100), 100) : 0;

        return view('dashboard', [
            'settings' => $settings,
            'recentJournals' => $recentJournals,
            'totalCash' => $totalCash,
            'totalRestricted' => $totalRestricted,
            'pendingCount' => $pendingCount,
            'baksosExpenses' => $baksosExpenses,
            'baksosProgress' => $baksosProgress,
            'role' => $user->role,
            'branchName' => $user->branch ? $user->branch->name : 'Pusat (DPP)',
        ]);
    }

    /**
     * Update the approval status of a journal transaction.
     */
    public function updateStatus(Request $request, Journal $journal)
    {
        $request->validate([
            'status' => 'required|in:reviewed,approved,rejected',
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        $status = $request->status;

        if ($status === 'reviewed') {
            if (!Gate::allows('review', $journal)) {
                abort(403, 'Unauthorized action.');
            }
            $journal->update([
                'status' => 'reviewed',
                'reviewed_by' => Auth::id(),
                'reviewed_at' => now(),
            ]);
        } elseif ($status === 'approved') {
            if (!Gate::allows('approve', $journal)) {
                abort(403, 'Unauthorized action.');
            }
            $journal->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);
        } elseif ($status === 'rejected') {
            // Can be rejected by bendahara (review level) or ketua (approve level)
            $canReject = Gate::allows('review', $journal) || Gate::allows('approve', $journal);
            if (!$canReject) {
                abort(403, 'Unauthorized action.');
            }
            $journal->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Status transaksi jurnal berhasil diperbarui.');
    }
}
