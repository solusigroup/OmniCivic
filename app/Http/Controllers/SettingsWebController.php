<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Services\IdentityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingsWebController extends Controller
{
    /**
     * Display the settings edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        $branch = Branch::find($user->branch_id);

        if (!$branch) {
            return redirect()->route('dashboard')->with('error', 'Cabang Anda tidak ditemukan.');
        }

        // Retrieve identity settings using the service
        $settings = IdentityService::getSettingsForBranch($branch->id);

        // Authorization check: Only 'Super Admin' or 'Ketua' (of that branch) can update settings
        $canManage = $user->isSuperAdmin() || ($user->isKetua() && (int) $user->branch_id === (int) $branch->id);

        return view('settings.branch', [
            'settings' => $settings,
            'branch' => $branch,
            'canManage' => $canManage,
        ]);
    }

    /**
     * Update the branch identity settings.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $branch = Branch::find($user->branch_id);

        if (!$branch) {
            return redirect()->route('dashboard')->with('error', 'Cabang Anda tidak ditemukan.');
        }

        // Authorization check: Only 'Super Admin' or 'Ketua' (of that branch) can update settings
        $canManage = $user->isSuperAdmin() || ($user->isKetua() && (int) $user->branch_id === (int) $branch->id);
        
        if (!$canManage) {
            abort(403, 'Akses ditolak. Hanya Ketua Cabang atau Super Admin yang diperbolehkan mengubah pengaturan.');
        }

        $validated = $request->validate([
            'party_name'          => ['required', 'string', 'max:150'],
            'branch_display_name' => ['required', 'string', 'max:150'],
            'address'             => ['required', 'string', 'max:250'],
            'phone'               => ['required', 'string', 'max:30'],
            'email'               => ['required', 'email', 'max:100'],
            'logo_party'          => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'logo_branch'         => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
        ]);

        $settings = $branch->identity_settings ?? [];

        // Update text settings
        foreach (['party_name', 'branch_display_name', 'address', 'phone', 'email'] as $field) {
            $settings[$field] = $validated[$field];
        }

        // Party Logo Upload
        if ($request->hasFile('logo_party')) {
            if (!empty($settings['logo_party_path'])) {
                Storage::disk('public')->delete($settings['logo_party_path']);
            }
            $path = $request->file('logo_party')->store('logos/party', 'public');
            $settings['logo_party_path'] = $path;
        }

        // Branch Logo Upload
        if ($request->hasFile('logo_branch')) {
            if (!empty($settings['logo_branch_path'])) {
                Storage::disk('public')->delete($settings['logo_branch_path']);
            }
            $path = $request->file('logo_branch')->store('logos/branches', 'public');
            $settings['logo_branch_path'] = $path;
        }

        // Update branch identity settings
        $branch->update([
            'identity_settings' => $settings,
        ]);

        return redirect()->route('settings.branch.edit')->with('success', 'Identitas dan logo cabang berhasil diperbarui.');
    }

    /**
     * Display a listing of chart of accounts.
     */
    public function coaIndex()
    {
        $user = Auth::user();
        $coas = \App\Models\ChartOfAccount::orderBy('code')->get();
        $branchId = $user->branch_id;
        $settings = IdentityService::getSettingsForBranch($branchId);

        $canManage = $user->isSuperAdmin() || $user->isKetua();

        return view('settings.coa', [
            'settings' => $settings,
            'coas' => $coas,
            'canManage' => $canManage,
            'role' => $user->role,
        ]);
    }

    /**
     * Store a newly created chart of account.
     */
    public function coaStore(Request $request)
    {
        $user = Auth::user();
        $canManage = $user->isSuperAdmin() || $user->isKetua();

        if (!$canManage) {
            abort(403, 'Akses ditolak. Anda tidak memiliki wewenang menambah akun.');
        }

        $validated = $request->validate([
            'code'              => ['required', 'string', 'max:20', 'unique:chart_of_accounts,code'],
            'name'              => ['required', 'string', 'max:200'],
            'type'              => ['required', 'in:asset,liability,equity,revenue,expense'],
            'restriction_type'  => ['required', 'in:unrestricted,temporarily_restricted,permanently_restricted'],
            'normal_balance'    => ['required', 'in:debit,credit'],
            'beginning_balance' => ['required', 'numeric', 'min:0'],
            'is_cash_or_bank'   => ['nullable', 'boolean'],
        ]);

        $validated['is_cash_or_bank'] = $request->has('is_cash_or_bank');

        \App\Models\ChartOfAccount::create($validated);

        return redirect()->route('settings.coa.index')->with('success', 'Akun COA baru berhasil ditambahkan.');
    }

    /**
     * Update the specified chart of account in storage.
     */
    public function coaUpdate(Request $request, \App\Models\ChartOfAccount $coa)
    {
        $user = Auth::user();
        $canManage = $user->isSuperAdmin() || $user->isKetua();

        if (!$canManage) {
            abort(403, 'Akses ditolak. Anda tidak memiliki wewenang mengubah akun.');
        }

        $validated = $request->validate([
            'code'              => ['required', 'string', 'max:20', 'unique:chart_of_accounts,code,' . $coa->id],
            'name'              => ['required', 'string', 'max:200'],
            'type'              => ['required', 'in:asset,liability,equity,revenue,expense'],
            'restriction_type'  => ['required', 'in:unrestricted,temporarily_restricted,permanently_restricted'],
            'normal_balance'    => ['required', 'in:debit,credit'],
            'beginning_balance' => ['required', 'numeric', 'min:0'],
            'is_cash_or_bank'   => ['nullable', 'boolean'],
        ]);

        $validated['is_cash_or_bank'] = $request->has('is_cash_or_bank');

        $coa->update($validated);

        return redirect()->route('settings.coa.index')->with('success', 'Akun COA berhasil diperbarui.');
    }

    /**
     * Remove the specified chart of account from storage.
     */
    public function coaDestroy(\App\Models\ChartOfAccount $coa)
    {
        $user = Auth::user();
        $canManage = $user->isSuperAdmin() || $user->isKetua();

        if (!$canManage) {
            abort(403, 'Akses ditolak. Anda tidak memiliki wewenang menghapus akun.');
        }

        // Check if this account has details/transactions linked to it
        if ($coa->journalDetails()->exists()) {
            return redirect()->route('settings.coa.index')->with('error', 'Akun COA tidak dapat dihapus karena sudah memiliki catatan transaksi.');
        }

        $coa->delete();

        return redirect()->route('settings.coa.index')->with('success', 'Akun COA berhasil dihapus.');
    }

    /**
     * Toggle active status of the chart of account.
     */
    public function coaToggleActive(\App\Models\ChartOfAccount $coa)
    {
        $user = Auth::user();
        $canManage = $user->isSuperAdmin() || $user->isKetua();

        if (!$canManage) {
            abort(403, 'Akses ditolak.');
        }

        $coa->update([
            'is_active' => !$coa->is_active
        ]);

        return redirect()->route('settings.coa.index')->with('success', 'Status keaktifan akun berhasil diubah.');
    }
}
