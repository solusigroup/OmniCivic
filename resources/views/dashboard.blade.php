<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Branch Identity Banner -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute top-[-50%] right-[-10%] w-96 h-96 bg-omni-primary/5 dark:bg-omni-primary/3 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex items-center gap-5 relative z-10">
                    <div class="w-14 h-14 bg-omni-primary rounded-2xl flex items-center justify-center text-white shadow-md shadow-omni-primary/20">
                        <!-- Hexagonal shield with financial green bars inside -->
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L3 7V12C3 17 7 21 12 22C17 21 21 17 21 12V7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M9 10V14" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                            <path d="M12 8V16" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                            <path d="M15 11V15" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">{{ $settings['branch_display_name'] }}</h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold tracking-wider uppercase">{{ $settings['party_name'] }}</p>
                        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">
                            {{ $settings['address'] }} &bull; {{ $settings['phone'] }} &bull; {{ $settings['email'] }}
                        </p>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1.5 relative z-10 text-right">
                    <span class="px-3 py-1.5 text-xs font-bold bg-omni-primary/10 text-omni-primary dark:bg-blue-900/30 dark:text-blue-400 rounded-xl border border-omni-primary/20 uppercase tracking-widest">
                        Hak Akses: {{ $role }}
                    </span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Masa Anggaran: 2026</span>
                </div>
            </div>

            <!-- Metrics Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card 1: Kas Konsolidasi -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Kas Konsolidasi</span>
                        <div class="w-10 h-10 rounded-xl bg-omni-primary/15 dark:bg-omni-primary/10 text-omni-primary dark:text-blue-400 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white">Rp {{ number_format($totalCash, 0, ',', '.') }}</h3>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Saldo Terdaftar</p>
                    </div>
                </div>

                <!-- Card 2: Sumbangan Terikat -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Sumbangan Terikat</span>
                        <div class="w-10 h-10 rounded-xl bg-omni-success/15 dark:bg-omni-success/10 text-omni-success flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white">Rp {{ number_format($totalRestricted, 0, ',', '.') }}</h3>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">ISAK 35 Terikat</p>
                    </div>
                </div>

                <!-- Card 3: Persetujuan Pending -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Persetujuan Pending</span>
                        <div class="w-10 h-10 rounded-xl bg-omni-pending/15 dark:bg-omni-pending/10 text-omni-pending flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white">{{ $pendingCount }} Transaksi</h3>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">Menunggu Tinjauan</p>
                    </div>
                </div>

                <!-- Card 4: Realisasi Program -->
                <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Realisasi Baksos</span>
                        <span class="text-xs font-black text-slate-900 dark:text-white">{{ $baksosProgress }}%</span>
                    </div>
                    <div class="space-y-3">
                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-omni-primary to-omni-success h-full rounded-full" style="width: {{ $baksosProgress }}%"></div>
                        </div>
                        <div class="flex justify-between items-center text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase">
                            <span>Pengeluaran:</span>
                            <span class="text-slate-700 dark:text-slate-300">Rp {{ number_format($baksosExpenses, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Success Alert -->
            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/25 text-emerald-500 px-5 py-4 rounded-2xl text-sm font-semibold flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Workflow & Recent Transactions List -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-slate-100 dark:border-slate-800 pb-5">
                    <div>
                        <h2 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">Transaksi Jurnal Terbaru</h2>
                        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Log riwayat transaksi keuangan pada cabang ini beserta status persetujuan workflow.</p>
                    </div>
                    <span class="px-2.5 py-1 text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-lg">
                        Total Terload: {{ $recentJournals->count() }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-800 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-4">Ref #</th>
                                <th class="py-3.5 px-4">Tanggal</th>
                                <th class="py-3.5 px-4">Deskripsi</th>
                                <th class="py-3.5 px-4">Tipe</th>
                                <th class="py-3.5 px-4 text-right">Nilai Total</th>
                                <th class="py-3.5 px-4 text-center">Status</th>
                                <th class="py-3.5 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                            @forelse($recentJournals as $journal)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                                    <td class="py-4 px-4 font-bold text-slate-900 dark:text-white">{{ $journal->reference_number }}</td>
                                    <td class="py-4 px-4 text-slate-500 dark:text-slate-400">{{ $journal->transaction_date->format('d/m/Y') }}</td>
                                    <td class="py-4 px-4">
                                        <span class="font-semibold block text-slate-800 dark:text-slate-200">{{ $journal->description }}</span>
                                        @if($journal->rejection_reason)
                                            <span class="text-xs text-rose-500 font-semibold block mt-1">Alasan Penolakan: {{ $journal->rejection_reason }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-2 py-0.5 text-[10px] font-bold rounded uppercase tracking-wide
                                            @if($journal->transaction_type === 'cash_in') bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-400
                                            @elseif($journal->transaction_type === 'cash_out') bg-rose-100 text-rose-800 dark:bg-rose-950/40 dark:text-rose-400
                                            @else bg-blue-100 text-blue-800 dark:bg-blue-950/40 dark:text-blue-400
                                            @endif">
                                            {{ str_replace('_', ' ', $journal->transaction_type) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-right font-black text-slate-900 dark:text-white">
                                        Rp {{ number_format($journal->details->sum('debit'), 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-2.5 py-1 text-xs font-bold rounded-lg uppercase tracking-wider
                                            @if($journal->status === 'draft') bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400
                                            @elseif($journal->status === 'reviewed') bg-amber-100 text-amber-800 dark:bg-amber-950/30 dark:text-amber-500 border border-amber-500/20
                                            @elseif($journal->status === 'approved') bg-emerald-100 text-emerald-800 dark:bg-emerald-950/30 dark:text-emerald-400 border border-emerald-500/20
                                            @else bg-rose-100 text-rose-800 dark:bg-rose-950/30 dark:text-rose-400 border border-rose-500/20
                                            @endif">
                                            {{ $journal->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <!-- Actions based on role policies -->
                                        @if($journal->status === 'draft' && ($role === 'bendahara' || $role === 'super_admin'))
                                            <form action="{{ route('journals.updateStatus', $journal) }}" method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status" value="reviewed">
                                                <button type="submit" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-sm cursor-pointer transition-colors">
                                                    Review & Tinjau
                                                </button>
                                            </form>
                                        @elseif($journal->status === 'reviewed' && ($role === 'ketua' || $role === 'super_admin'))
                                            <div class="flex justify-end gap-2">
                                                <form action="{{ route('journals.updateStatus', $journal) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl shadow-sm cursor-pointer transition-colors">
                                                        Setujui
                                                    </button>
                                                </form>
                                                <button type="button" 
                                                        onclick="showRejectModal('{{ route('journals.updateStatus', $journal) }}')" 
                                                        class="px-3 py-1.5 bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs rounded-xl shadow-sm cursor-pointer transition-colors">
                                                    Tolak
                                                </button>
                                            </div>
                                        @elseif(($journal->status === 'draft' || $journal->status === 'rejected') && ($role === 'staff' || $role === 'super_admin'))
                                            <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">Bisa diedit Operator</span>
                                        @else
                                            <span class="text-xs text-slate-400 dark:text-slate-500 font-medium">Selesai terproses</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-center text-slate-400 font-medium">Belum ada transaksi terdaftar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Reject Modal Dialog -->
    <div id="rejectModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background Overlay -->
            <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity" aria-hidden="true" onclick="hideRejectModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="rejectForm" method="POST" class="p-6 sm:p-8 space-y-6">
                    @csrf
                    <input type="hidden" name="status" value="rejected">
                    
                    <div class="space-y-2">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white" id="modal-title">Tolak Transaksi Jurnal</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Harap berikan alasan penolakan untuk transaksi ini agar Operator/Staff dapat melakukan perbaikan.</p>
                    </div>

                    <div class="space-y-2">
                        <label for="rejection_reason" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase">Alasan Penolakan</label>
                        <textarea id="rejection_reason" name="rejection_reason" rows="3" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30" placeholder="Tulis alasan di sini..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" onclick="hideRejectModal()" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs rounded-xl shadow-sm cursor-pointer transition-colors">
                            Tolak Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal script helper -->
    <script>
        function showRejectModal(actionUrl) {
            const modal = document.getElementById('rejectModal');
            const form = document.getElementById('rejectForm');
            form.action = actionUrl;
            modal.classList.remove('hidden');
        }

        function hideRejectModal() {
            const modal = document.getElementById('rejectModal');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
