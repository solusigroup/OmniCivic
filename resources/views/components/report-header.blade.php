@php
    use App\Services\IdentityService;
    use Illuminate\Support\Facades\Auth;

    $branchId = Auth::user()?->branch_id;
    $settings = IdentityService::getSettingsForBranch($branchId);
@endphp

<div class="w-full bg-white dark:bg-slate-900 p-6 border-b-4 border-double border-slate-900 dark:border-slate-100 flex items-center justify-between font-sans">
    <!-- Left: Party Logo -->
    <div class="flex-shrink-0 w-24 h-24 flex items-center justify-center">
        @if (!empty($settings['logo_party_path']))
            <img src="{{ asset('storage/' . $settings['logo_party_path']) }}" alt="{{ $settings['party_name'] }} Logo" class="max-h-24 max-w-24 object-contain">
        @else
            <!-- Beautiful Modern SVG Laurel Shield representing Central Party Emblem -->
            <svg class="w-20 h-20 text-omni-primary" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M50 12C32 12 20 22 20 38C20 62 50 88 50 88C50 88 80 62 80 38C80 22 68 12 50 12Z" fill="currentColor" fill-opacity="0.1"/>
                <path d="M50 15C34 15 22 24.5 22 39C22 61 50 85 50 85C50 85 78 61 78 39C78 24.5 66 15 50 15Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M50 25C42 25 36 30 36 38C36 50 50 68 50 68C50 68 64 50 64 38C64 30 58 25 50 25Z" fill="currentColor" fill-opacity="0.2"/>
                <circle cx="50" cy="38" r="6" fill="currentColor"/>
            </svg>
        @endif
    </div>

    <!-- Center: Branch Information -->
    <div class="flex-grow text-center px-6">
        <h1 class="text-2xl font-extrabold tracking-wide uppercase text-slate-900 dark:text-white leading-tight">
            {{ $settings['party_name'] }}
        </h1>
        <h2 class="text-lg font-semibold text-omni-primary dark:text-blue-400 mt-0.5">
            {{ $settings['branch_display_name'] }}
        </h2>
        <div class="text-xs text-slate-600 dark:text-slate-400 mt-2 space-y-0.5 font-medium">
            <p>{{ $settings['address'] }}</p>
            <p class="flex items-center justify-center gap-4 mt-1">
                <span><strong class="text-slate-800 dark:text-slate-200">Telp:</strong> {{ $settings['phone'] }}</span>
                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
                <span><strong class="text-slate-800 dark:text-slate-200">Email:</strong> {{ $settings['email'] }}</span>
            </p>
        </div>
    </div>

    <!-- Right: Branch Logo (Optional) -->
    <div class="flex-shrink-0 w-24 h-24 flex items-center justify-center">
        @if (!empty($settings['logo_branch_path']))
            <img src="{{ asset('storage/' . $settings['logo_branch_path']) }}" alt="Logo Cabang" class="max-h-24 max-w-24 object-contain">
        @else
            <!-- Placeholder structure matching the left side's layout but invisible/transparent for alignment balance -->
            <div class="w-20 h-20 opacity-0 pointer-events-none"></div>
        @endif
    </div>
</div>
