<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Audit Trail</h1>
                    <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Log aktivitas perubahan data pada sistem.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 text-xs font-bold text-slate-400 uppercase">
                            <th class="py-3.5 px-4">Waktu</th>
                            <th class="py-3.5 px-4">User</th>
                            <th class="py-3.5 px-4">Event</th>
                            <th class="py-3.5 px-4">Model</th>
                            <th class="py-3.5 px-4">IP Address</th>
                            <th class="py-3.5 px-4">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                        @forelse($audits as $audit)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20">
                            <td class="py-4 px-4 whitespace-nowrap">{{ $audit->created_at->format('d/m/Y H:i:s') }}</td>
                            <td class="py-4 px-4 font-bold">{{ $audit->user ? $audit->user->name : 'System' }}</td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded uppercase tracking-wide
                                    @if($audit->event === 'created') bg-emerald-100 text-emerald-800
                                    @elseif($audit->event === 'updated') bg-blue-100 text-blue-800
                                    @elseif($audit->event === 'deleted') bg-rose-100 text-rose-800
                                    @else bg-slate-100 text-slate-800
                                    @endif">
                                    {{ $audit->event }}
                                </span>
                            </td>
                            <td class="py-4 px-4 font-semibold">{{ class_basename($audit->auditable_type) }} (ID: {{ $audit->auditable_id }})</td>
                            <td class="py-4 px-4 text-xs">{{ $audit->ip_address }}</td>
                            <td class="py-4 px-4">
                                <details class="text-xs">
                                    <summary class="cursor-pointer text-omni-primary font-bold">Lihat Perubahan</summary>
                                    <div class="mt-2 bg-slate-50 dark:bg-slate-800 p-3 rounded-xl border border-slate-100 dark:border-slate-700 space-y-2">
                                        @if($audit->old_values)
                                        <div>
                                            <strong class="block text-rose-500 mb-1">Old Values:</strong>
                                            <pre class="whitespace-pre-wrap font-mono text-[10px] overflow-x-auto">{{ json_encode($audit->old_values, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                        @endif
                                        @if($audit->new_values)
                                        <div>
                                            <strong class="block text-emerald-500 mb-1">New Values:</strong>
                                            <pre class="whitespace-pre-wrap font-mono text-[10px] overflow-x-auto">{{ json_encode($audit->new_values, JSON_PRETTY_PRINT) }}</pre>
                                        </div>
                                        @endif
                                    </div>
                                </details>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-medium">Belum ada log audit.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $audits->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
