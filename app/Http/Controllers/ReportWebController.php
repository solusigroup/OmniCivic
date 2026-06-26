<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\JournalDetail;
use App\Models\ChartOfAccount;
use App\Services\IdentityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportWebController extends Controller
{
    /**
     * Display report filters and output.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $branchId = $user->branch_id;
        $settings = IdentityService::getSettingsForBranch($branchId);

        $reportType = $request->input('type', 'cash_flow'); // cash_flow, activity, position

        // Scope approved journals
        $approvedJournalIds = Journal::where('status', 'approved');
        if ($user->role !== 'super_admin') {
            $approvedJournalIds->where('branch_id', $branchId);
        }
        $approvedJournalIds = $approvedJournalIds->pluck('id');

        // Fetch accounts and details
        $details = JournalDetail::whereIn('journal_id', $approvedJournalIds)->with('account')->get();

        $cashFlowData = [];
        $activityData = [];
        $positionData = [];

        if ($reportType === 'cash_flow') {
            // Cash Inflows (Receipts on cash/bank accounts)
            $receipts = [];
            $disbursements = [];
            $totalReceipts = 0;
            $totalDisbursements = 0;

            // Loop details to categorize cash flows
            foreach ($details as $detail) {
                // If it's a cash/bank transaction, we trace the offsetting lines
                // Simplification for Cash Flow (Receipts vs Disbursements based on double-entry normal balance):
                if ($detail->account->type === 'revenue' && $detail->credit > 0) {
                    $accName = $detail->account->name;
                    $receipts[$accName] = ($receipts[$accName] ?? 0) + $detail->credit;
                    $totalReceipts += $detail->credit;
                } elseif ($detail->account->type === 'expense' && $detail->debit > 0) {
                    $accName = $detail->account->name;
                    $disbursements[$accName] = ($disbursements[$accName] ?? 0) + $detail->debit;
                    $totalDisbursements += $detail->debit;
                }
            }

            $cashFlowData = [
                'receipts' => $receipts,
                'disbursements' => $disbursements,
                'totalReceipts' => $totalReceipts,
                'totalDisbursements' => $totalDisbursements,
                'netCash' => $totalReceipts - $totalDisbursements,
            ];

        } elseif ($reportType === 'activity') {
            // Revenues by restriction
            $unrestrictedRev = [];
            $restrictedRev = [];
            $totalUnrestrictedRev = 0;
            $totalRestrictedRev = 0;

            $expenses = [];
            $totalExpenses = 0;

            foreach ($details as $detail) {
                if ($detail->account->type === 'revenue' && $detail->credit > 0) {
                    $accName = $detail->account->name;
                    if ($detail->account->restriction_type === 'unrestricted') {
                        $unrestrictedRev[$accName] = ($unrestrictedRev[$accName] ?? 0) + $detail->credit;
                        $totalUnrestrictedRev += $detail->credit;
                    } else {
                        $restrictedRev[$accName] = ($restrictedRev[$accName] ?? 0) + $detail->credit;
                        $totalRestrictedRev += $detail->credit;
                    }
                } elseif ($detail->account->type === 'expense' && $detail->debit > 0) {
                    $accName = $detail->account->name;
                    $expenses[$accName] = ($expenses[$accName] ?? 0) + $detail->debit;
                    $totalExpenses += $detail->debit;
                }
            }

            $activityData = [
                'unrestrictedRev' => $unrestrictedRev,
                'restrictedRev' => $restrictedRev,
                'totalUnrestrictedRev' => $totalUnrestrictedRev,
                'totalRestrictedRev' => $totalRestrictedRev,
                'totalRevenues' => $totalUnrestrictedRev + $totalRestrictedRev,
                'expenses' => $expenses,
                'totalExpenses' => $totalExpenses,
                'netChange' => ($totalUnrestrictedRev + $totalRestrictedRev) - $totalExpenses,
            ];

        } elseif ($reportType === 'position') {
            // Assets, Liabilities, Net Assets (Equity)
            $assets = [];
            $liabilities = [];
            $netAssets = [];

            $totalAssets = 0;
            $totalLiabilities = 0;
            $totalNetAssets = 0;

            // Fetch current balances for accounts
            $accounts = ChartOfAccount::where('is_active', true)->get();
            foreach ($accounts as $acc) {
                // Get approved details for this specific account
                $accDetails = JournalDetail::whereIn('journal_id', $approvedJournalIds)
                    ->where('account_id', $acc->id)
                    ->get();
                
                $balance = (float) $acc->beginning_balance;
                foreach ($accDetails as $d) {
                    if ($acc->normal_balance === 'debit') {
                        $balance += ($d->debit - $d->credit);
                    } else {
                        $balance += ($d->credit - $d->debit);
                    }
                }

                if ($balance != 0 || $acc->is_cash_or_bank) {
                    if ($acc->type === 'asset') {
                        $assets[$acc->name] = $balance;
                        $totalAssets += $balance;
                    } elseif ($acc->type === 'liability') {
                        $liabilities[$acc->name] = $balance;
                        $totalLiabilities += $balance;
                    } elseif ($acc->type === 'equity') {
                        $netAssets[$acc->name] = $balance;
                        $totalNetAssets += $balance;
                    }
                }
            }

            // Adjust Net Assets to include current surplus change if equity doesn't sum up yet
            $positionData = [
                'assets' => $assets,
                'totalAssets' => $totalAssets,
                'liabilities' => $liabilities,
                'totalLiabilities' => $totalLiabilities,
                'netAssets' => $netAssets,
                'totalNetAssets' => $totalNetAssets,
            ];
        }

        return view('reports.index', [
            'settings' => $settings,
            'reportType' => $reportType,
            'cashFlowData' => $cashFlowData,
            'activityData' => $activityData,
            'positionData' => $positionData,
            'branchName' => $user->branch ? $user->branch->name : 'Pusat (DPP)',
        ]);
    }
}
