<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\ChartOfAccount;
use App\Models\Program;
use App\Models\Division;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $budgets = Budget::with(['account', 'program', 'division'])
            ->forYear($year)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $totalBudget = Budget::forYear($year)->sum('amount');
        
        return view('budgets.index', compact('budgets', 'year', 'totalBudget'));
    }

    public function create()
    {
        $accounts = ChartOfAccount::where('type', 'expense')->get();
        $programs = Program::where('is_active', true)->get();
        $divisions = Division::where('is_active', true)->get();
        return view('budgets.create', compact('accounts', 'programs', 'divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'account_id' => 'required|exists:chart_of_accounts,id',
            'program_id' => 'required|exists:programs,id',
            'division_id' => 'required|exists:divisions,id',
            'amount' => 'required|numeric|min:0',
            'fiscal_year' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        Budget::create($request->all());

        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil ditambahkan.');
    }

    public function edit(Budget $budget)
    {
        $accounts = ChartOfAccount::where('type', 'expense')->get();
        $programs = Program::where('is_active', true)->get();
        $divisions = Division::where('is_active', true)->get();
        return view('budgets.edit', compact('budget', 'accounts', 'programs', 'divisions'));
    }

    public function update(Request $request, Budget $budget)
    {
        $request->validate([
            'account_id' => 'required|exists:chart_of_accounts,id',
            'program_id' => 'required|exists:programs,id',
            'division_id' => 'required|exists:divisions,id',
            'amount' => 'required|numeric|min:0',
            'fiscal_year' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        $budget->update($request->all());

        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil diperbarui.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Anggaran berhasil dihapus.');
    }
}
