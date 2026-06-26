<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IdentitySettingsController extends Controller
{
    /**
     * Update identity settings for a branch (e.g. uploading logos, updating address).
     *
     * Rules:
     * - Only 'Super Admin' or 'Ketua' (of that branch) can update settings.
     * - Saves files to public storage disk and updates branch JSON column.
     *
     * @param  Request  $request
     * @param  Branch  $branch
     * @return JsonResponse
     */
    public function update(Request $request, Branch $branch): JsonResponse
    {
        $user = Auth::user();

        // 1. Authorize: Must be active, and either Super Admin or Ketua of this branch
        if (!$user->isActive()) {
            return response()->json(['success' => false, 'message' => 'User account is inactive.'], 403);
        }

        if (!$user->isSuperAdmin()) {
            if (!$user->isKetua() || (int) $user->branch_id !== (int) $branch->id) {
                return response()->json(['success' => false, 'message' => 'Unauthorized. Only Ketua of this branch or Super Admin can manage identity settings.'], 403);
            }
        }

        // 2. Validate request parameters
        $validated = $request->validate([
            'party_name'          => ['nullable', 'string', 'max:150'],
            'branch_display_name' => ['nullable', 'string', 'max:150'],
            'address'             => ['nullable', 'string', 'max:250'],
            'phone'               => ['nullable', 'string', 'max:30'],
            'email'               => ['nullable', 'email', 'max:100'],
            'logo_party'          => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'logo_branch'         => ['nullable', 'image', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
        ]);

        try {
            // Get current settings or default to empty array
            $settings = $branch->identity_settings ?? [];

            // Update text settings
            foreach (['party_name', 'branch_display_name', 'address', 'phone', 'email'] as $field) {
                if ($request->has($field)) {
                    $settings[$field] = $validated[$field] ?? null;
                }
            }

            // 3. Handle Party Logo upload (saves to central storage)
            if ($request->hasFile('logo_party')) {
                // Delete old file if exists
                if (!empty($settings['logo_party_path'])) {
                    Storage::disk('public')->delete($settings['logo_party_path']);
                }
                $path = $request->file('logo_party')->store('logos/party', 'public');
                $settings['logo_party_path'] = $path;
            }

            // 4. Handle Branch Logo upload (saves to branch specific storage)
            if ($request->hasFile('logo_branch')) {
                // Delete old file if exists
                if (!empty($settings['logo_branch_path'])) {
                    Storage::disk('public')->delete($settings['logo_branch_path']);
                }
                $path = $request->file('logo_branch')->store('logos/branches', 'public');
                $settings['logo_branch_path'] = $path;
            }

            // 5. Update branch database record
            $branch->update([
                'identity_settings' => $settings,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Branch identity settings updated successfully.',
                'data'    => $branch->fresh(),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update identity settings.',
                'data'    => null,
            ], 500);
        }
    }
}
