<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\JournalDetail;
use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

/**
 * Controller for managing cash-basis accounting transactions.
 *
 * Handles three types of transactions for political party accounting:
 * - Cash In:   Debit Cash/Bank, Credit Revenue/Fund Source
 * - Cash Out:  Debit Expense, Credit Cash/Bank
 * - Transfer:  Debit Destination Cash/Bank, Credit Origin Cash/Bank
 *
 * All operations are protected by multi-tenant branch checks and role policies.
 */
class CashTransactionController extends Controller
{
    /**
     * Helper to verify if the authenticated user has access to a given branch.
     * Super Admins have global access.
     */
    private function verifyBranchAccess(int $branchId): void
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return;
        }

        if ((int) $user->branch_id !== $branchId) {
            abort(403, 'Unauthorized branch access. You do not belong to this branch.');
        }
    }

    /**
     * Record a cash-in transaction.
     *
     * Creates a journal entry that debits a cash/bank account and credits
     * a revenue/fund source account for the given amount.
     */
    public function cashIn(Request $request): JsonResponse
    {
        // 1. Policy check: Must have 'staff' role
        Gate::authorize('create', Journal::class);

        $validated = $request->validate([
            'branch_id'          => ['required', 'exists:branches,id'],
            'transaction_date'   => ['required', 'date'],
            'description'        => ['nullable', 'string', 'max:500'],
            'cash_account_id'    => ['required', 'exists:chart_of_accounts,id'],
            'revenue_account_id' => ['required', 'exists:chart_of_accounts,id'],
            'amount'             => ['required', 'numeric', 'min:0.01'],
            'program_id'         => ['nullable', 'exists:programs,id'],
            'division_id'        => ['nullable', 'exists:divisions,id'],
            'fund_source_id'     => ['nullable', 'exists:fund_sources,id'],
        ]);

        // 2. Multi-tenant row-level branch check
        $this->verifyBranchAccess((int) $validated['branch_id']);

        try {
            $journal = DB::transaction(function () use ($validated) {
                $referenceNumber = $this->generateReferenceNumber('CI');

                $journal = Journal::create([
                    'reference_number'  => $referenceNumber,
                    'branch_id'         => $validated['branch_id'],
                    'transaction_date'  => $validated['transaction_date'],
                    'description'       => $validated['description'] ?? null,
                    'status'            => 'draft',
                    'transaction_type'  => 'cash_in',
                    'created_by'        => Auth::id(),
                ]);

                // Line 1: Debit to Cash/Bank account
                JournalDetail::create([
                    'journal_id'     => $journal->id,
                    'account_id'     => $validated['cash_account_id'],
                    'debit'          => $validated['amount'],
                    'credit'         => 0,
                    'program_id'     => $validated['program_id'] ?? null,
                    'division_id'    => $validated['division_id'] ?? null,
                    'fund_source_id' => $validated['fund_source_id'] ?? null,
                ]);

                // Line 2: Credit to Revenue/Fund Source account
                JournalDetail::create([
                    'journal_id'     => $journal->id,
                    'account_id'     => $validated['revenue_account_id'],
                    'debit'          => 0,
                    'credit'         => $validated['amount'],
                    'program_id'     => $validated['program_id'] ?? null,
                    'division_id'    => $validated['division_id'] ?? null,
                    'fund_source_id' => $validated['fund_source_id'] ?? null,
                ]);

                return $journal->load('details');
            });

            return response()->json([
                'success' => true,
                'message' => 'Cash-in transaction created successfully.',
                'data'    => $journal,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create cash-in transaction.',
                'data'    => null,
            ], 500);
        }
    }

    /**
     * Record a cash-out transaction.
     *
     * Creates a journal entry that debits an expense account and credits
     * a cash/bank account for the given amount.
     */
    public function cashOut(Request $request): JsonResponse
    {
        // 1. Policy check: Must have 'staff' role
        Gate::authorize('create', Journal::class);

        $validated = $request->validate([
            'branch_id'          => ['required', 'exists:branches,id'],
            'transaction_date'   => ['required', 'date'],
            'description'        => ['nullable', 'string', 'max:500'],
            'expense_account_id' => ['required', 'exists:chart_of_accounts,id'],
            'cash_account_id'    => ['required', 'exists:chart_of_accounts,id'],
            'amount'             => ['required', 'numeric', 'min:0.01'],
            'program_id'         => ['nullable', 'exists:programs,id'],
            'division_id'        => ['nullable', 'exists:divisions,id'],
            'fund_source_id'     => ['nullable', 'exists:fund_sources,id'],
        ]);

        // 2. Multi-tenant row-level branch check
        $this->verifyBranchAccess((int) $validated['branch_id']);

        try {
            $journal = DB::transaction(function () use ($validated) {
                $referenceNumber = $this->generateReferenceNumber('CO');

                $journal = Journal::create([
                    'reference_number'  => $referenceNumber,
                    'branch_id'         => $validated['branch_id'],
                    'transaction_date'  => $validated['transaction_date'],
                    'description'       => $validated['description'] ?? null,
                    'status'            => 'draft',
                    'transaction_type'  => 'cash_out',
                    'created_by'        => Auth::id(),
                ]);

                // Line 1: Debit to Expense account
                JournalDetail::create([
                    'journal_id'     => $journal->id,
                    'account_id'     => $validated['expense_account_id'],
                    'debit'          => $validated['amount'],
                    'credit'         => 0,
                    'program_id'     => $validated['program_id'] ?? null,
                    'division_id'    => $validated['division_id'] ?? null,
                    'fund_source_id' => $validated['fund_source_id'] ?? null,
                ]);

                // Line 2: Credit from Cash/Bank account
                JournalDetail::create([
                    'journal_id'     => $journal->id,
                    'account_id'     => $validated['cash_account_id'],
                    'debit'          => 0,
                    'credit'         => $validated['amount'],
                    'program_id'     => $validated['program_id'] ?? null,
                    'division_id'    => $validated['division_id'] ?? null,
                    'fund_source_id' => $validated['fund_source_id'] ?? null,
                ]);

                return $journal->load('details');
            });

            return response()->json([
                'success' => true,
                'message' => 'Cash-out transaction created successfully.',
                'data'    => $journal,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create cash-out transaction.',
                'data'    => null,
            ], 500);
        }
    }

    /**
     * Record a transfer transaction between cash/bank accounts.
     *
     * Creates a journal entry that debits the destination cash/bank account
     * and credits the origin cash/bank account for the given amount.
     */
    public function transfer(Request $request): JsonResponse
    {
        // 1. Policy check: Must have 'staff' role
        Gate::authorize('create', Journal::class);

        $validated = $request->validate([
            'branch_id'              => ['required', 'exists:branches,id'],
            'transaction_date'       => ['required', 'date'],
            'description'            => ['nullable', 'string', 'max:500'],
            'destination_account_id' => ['required', 'exists:chart_of_accounts,id', 'different:origin_account_id'],
            'origin_account_id'      => ['required', 'exists:chart_of_accounts,id'],
            'amount'                 => ['required', 'numeric', 'min:0.01'],
            'program_id'             => ['nullable', 'exists:programs,id'],
            'division_id'            => ['nullable', 'exists:divisions,id'],
            'fund_source_id'         => ['nullable', 'exists:fund_sources,id'],
        ]);

        // 2. Multi-tenant row-level branch check
        $this->verifyBranchAccess((int) $validated['branch_id']);

        try {
            $journal = DB::transaction(function () use ($validated) {
                $referenceNumber = $this->generateReferenceNumber('TR');

                $journal = Journal::create([
                    'reference_number'  => $referenceNumber,
                    'branch_id'         => $validated['branch_id'],
                    'transaction_date'  => $validated['transaction_date'],
                    'description'       => $validated['description'] ?? null,
                    'status'            => 'draft',
                    'transaction_type'  => 'transfer',
                    'created_by'        => Auth::id(),
                ]);

                // Line 1: Debit to Destination Cash/Bank account
                JournalDetail::create([
                    'journal_id'     => $journal->id,
                    'account_id'     => $validated['destination_account_id'],
                    'debit'          => $validated['amount'],
                    'credit'         => 0,
                    'program_id'     => $validated['program_id'] ?? null,
                    'division_id'    => $validated['division_id'] ?? null,
                    'fund_source_id' => $validated['fund_source_id'] ?? null,
                ]);

                // Line 2: Credit from Origin Cash/Bank account
                JournalDetail::create([
                    'journal_id'     => $journal->id,
                    'account_id'     => $validated['origin_account_id'],
                    'debit'          => 0,
                    'credit'         => $validated['amount'],
                    'program_id'     => $validated['program_id'] ?? null,
                    'division_id'    => $validated['division_id'] ?? null,
                    'fund_source_id' => $validated['fund_source_id'] ?? null,
                ]);

                return $journal->load('details');
            });

            return response()->json([
                'success' => true,
                'message' => 'Transfer transaction created successfully.',
                'data'    => $journal,
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create transfer transaction.',
                'data'    => null,
            ], 500);
        }
    }

    /**
     * Display the specified journal with all related data.
     */
    public function show(Journal $journal): JsonResponse
    {
        // Policy check: Must belong to same branch or be super_admin
        Gate::authorize('view', $journal);

        $journal->load([
            'details.account',
            'details.program',
            'details.division',
            'details.fundSource',
            'branch',
            'creator',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Journal retrieved successfully.',
            'data'    => $journal,
        ]);
    }

    /**
     * Update the status of a journal entry.
     *
     * Enforces strict row-level security and state machine transitions:
     * - draft    → reviewed (review policy check)
     * - reviewed → approved (approve policy check)
     * - draft/reviewed → rejected (review/approve policy check depending on stage)
     */
    public function updateStatus(Request $request, Journal $journal): JsonResponse
    {
        $validated = $request->validate([
            'status'           => ['required', Rule::in(['reviewed', 'approved', 'rejected'])],
            'rejection_reason' => ['required_if:status,rejected', 'nullable', 'string', 'max:500'],
        ]);

        $currentStatus = $journal->status;
        $newStatus     = $validated['status'];

        // Enforce state machine transitions
        $validTransitions = [
            'draft'    => ['reviewed', 'rejected'],
            'reviewed' => ['approved', 'rejected'],
        ];

        $allowedStatuses = $validTransitions[$currentStatus] ?? [];

        if (!in_array($newStatus, $allowedStatuses, true)) {
            return response()->json([
                'success' => false,
                'message' => "Invalid status transition from '{$currentStatus}' to '{$newStatus}'.",
                'data'    => null,
            ], 422);
        }

        // --- ENFORCE POLICIES ---
        if ($newStatus === 'reviewed') {
            Gate::authorize('review', $journal);
        } elseif ($newStatus === 'approved') {
            Gate::authorize('approve', $journal);
        } elseif ($newStatus === 'rejected') {
            if ($currentStatus === 'draft') {
                Gate::authorize('review', $journal);
            } elseif ($currentStatus === 'reviewed') {
                Gate::authorize('approve', $journal);
            }
        }

        try {
            DB::transaction(function () use ($journal, $validated, $newStatus) {
                $journal->status = $newStatus;

                match ($newStatus) {
                    'reviewed' => $journal->forceFill([
                        'reviewed_by' => Auth::id(),
                        'reviewed_at' => now(),
                    ]),
                    'approved' => $journal->forceFill([
                        'approved_by' => Auth::id(),
                        'approved_at' => now(),
                    ]),
                    'rejected' => $journal->forceFill([
                        'rejection_reason' => $validated['rejection_reason'],
                    ]),
                };

                $journal->save();
            });

            return response()->json([
                'success' => true,
                'message' => "Journal status updated to '{$newStatus}' successfully.",
                'data'    => $journal->fresh(),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update journal status.',
                'data'    => null,
            ], 500);
        }
    }

    /**
     * Generate a sequential reference number for a given transaction type prefix.
     */
    private function generateReferenceNumber(string $prefix): string
     {
         $date = now()->format('Ymd');
         $lastJournal = Journal::where('reference_number', 'like', "{$prefix}-{$date}-%")
             ->orderByDesc('reference_number')
             ->first();
 
         if ($lastJournal) {
             $lastNumber = (int) substr($lastJournal->reference_number, -4);
             $nextNumber = $lastNumber + 1;
         } else {
             $nextNumber = 1;
         }
 
         return sprintf('%s-%s-%04d', $prefix, $date, $nextNumber);
     }
}
