<?php

namespace App\Services;

use App\Models\Branch;

class IdentityService
{
    /**
     * Fetch identity settings for a given branch, falling back to the root DPP branch if needed.
     *
     * Settings structure:
     * [
     *     'party_name'          => 'Partai Omni',
     *     'branch_display_name' => 'DPD Jawa Barat',
     *     'logo_party_path'     => 'logos/central-logo.png',
     *     'logo_branch_path'    => 'logos/branch-logo.png',
     *     'address'             => 'Jl. Jenderal Sudirman No. 123, Bandung',
     *     'phone'               => '022-123456',
     *     'email'               => 'dpd.jabar@partaiomni.or.id'
     * ]
     *
     * @param  int|null  $branchId
     * @return array
     */
    public static function getSettingsForBranch(?int $branchId): array
    {
        // 1. Define default empty settings structure
        $defaults = [
            'party_name'          => 'Partai Omni',
            'branch_display_name' => 'Dewan Pimpinan Pusat (DPP)',
            'logo_party_path'     => null,
            'logo_branch_path'    => null,
            'address'             => 'Kantor Pusat DPP, Jakarta',
            'phone'               => '021-999999',
            'email'               => 'dpp@partaiomni.or.id',
        ];

        // 2. Fetch root branch settings (parent_id is null - representing DPP)
        $rootBranch = Branch::whereNull('parent_id')->first();
        $rootSettings = $rootBranch && $rootBranch->identity_settings 
            ? array_merge($defaults, array_filter($rootBranch->identity_settings))
            : $defaults;

        if (!$branchId) {
            return $rootSettings;
        }

        // 3. Fetch target branch settings
        $branch = Branch::find($branchId);
        
        if (!$branch) {
            return $rootSettings;
        }

        // 4. Merge target settings with root fallbacks for missing/empty fields
        $branchSettings = $branch->identity_settings ? array_filter($branch->identity_settings) : [];

        return array_merge($rootSettings, [
            // local branch display name defaults to the branch's name from database if not configured in JSON
            'branch_display_name' => $branchSettings['branch_display_name'] ?? $branch->name,
            'logo_branch_path'    => $branchSettings['logo_branch_path'] ?? null,
            'logo_party_path'     => $branchSettings['logo_party_path'] ?? $rootSettings['logo_party_path'],
            'address'             => $branchSettings['address'] ?? $rootSettings['address'],
            'phone'               => $branchSettings['phone'] ?? $rootSettings['phone'],
            'email'               => $branchSettings['email'] ?? $rootSettings['email'],
        ]);
    }
}
