<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-955 min-h-screen text-slate-800 dark:text-slate-200"
         x-data="{ 
            showEditModal: false, 
            editAction: '', 
            editCoa: { id: '', code: '', name: '', type: 'asset', restriction_type: 'unrestricted', normal_balance: 'debit', beginning_balance: 0, is_cash_or_bank: false } 
         }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Header Banner -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute top-[-50%] right-[-10%] w-96 h-96 bg-omni-primary/5 dark:bg-omni-primary/3 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex items-center gap-5 relative z-10">
                    <div class="w-14 h-14 bg-omni-primary rounded-2xl flex items-center justify-center text-white shadow-md shadow-omni-primary/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Master Bagan Akun (COA)</h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">{{ $settings['branch_display_name'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/25 text-emerald-500 px-5 py-4 rounded-2xl text-sm font-semibold flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-500/10 border border-rose-500/25 text-rose-500 px-5 py-4 rounded-2xl text-sm font-semibold flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Main Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left: COA Table List -->
                <div class="lg:col-span-2 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                    <div>
                        <h2 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">Daftar Bagan Akun Standar (BAS)</h2>
                        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Bagan akun standar yang digunakan untuk mencatat dan menghasilkan laporan keuangan ISAK 35.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                                    <th class="py-3 px-4">Kode</th>
                                    <th class="py-3 px-4">Nama Akun</th>
                                    <th class="py-3 px-4">Klasifikasi</th>
                                    <th class="py-3 px-4">Restriksi</th>
                                    <th class="py-3 px-4 text-right">Saldo Awal</th>
                                    <th class="py-3 px-4 text-center">Status</th>
                                    @if($canManage)
                                        <th class="py-3 px-4 text-right">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                                @forelse($coas as $coa)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/10 transition-colors">
                                        <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white">{{ $coa->code }}</td>
                                        <td class="py-3.5 px-4">
                                            <span class="font-semibold text-slate-800 dark:text-slate-200 block">{{ $coa->name }}</span>
                                            @if($coa->is_cash_or_bank)
                                                <span class="inline-block mt-0.5 px-1.5 py-0.5 text-[9px] font-bold bg-emerald-100 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-400 rounded">KAS/BANK</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span class="text-xs uppercase font-bold text-slate-500">
                                                @if($coa->type === 'asset') Aset
                                                @elseif($coa->type === 'liability') Liabilitas
                                                @elseif($coa->type === 'equity') Aset Neto
                                                @elseif($coa->type === 'revenue') Pendapatan
                                                @else Beban
                                                @endif
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <span class="text-xs text-slate-600 dark:text-slate-400">
                                                @if($coa->restriction_type === 'unrestricted') Tanpa Pembatasan
                                                @elseif($coa->restriction_type === 'temporarily_restricted') Terikat Temporer
                                                @else Terikat Permanen
                                                @endif
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-right font-black text-slate-900 dark:text-white">
                                            Rp {{ number_format($coa->beginning_balance, 0, ',', '.') }}
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            @if($canManage)
                                                <form action="{{ route('settings.coa.toggle', $coa) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="px-2 py-1 text-[10px] font-bold rounded-lg uppercase tracking-wide cursor-pointer transition-colors {{ $coa->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/30 dark:text-emerald-400 hover:bg-rose-100 hover:text-rose-800 dark:hover:bg-rose-950/30' : 'bg-rose-100 text-rose-800 dark:bg-rose-950/30 dark:text-rose-400 hover:bg-emerald-100 hover:text-emerald-800 dark:hover:bg-emerald-950/30' }}">
                                                        {{ $coa->is_active ? 'Aktif' : 'Non-Aktif' }}
                                                    </button>
                                                </form>
                                            @else
                                                <span class="px-2 py-1 text-[10px] font-bold rounded-lg uppercase tracking-wide {{ $coa->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/20 dark:text-emerald-400' : 'bg-rose-100 text-rose-800 dark:bg-rose-950/20 dark:text-rose-400' }}">
                                                    {{ $coa->is_active ? 'Aktif' : 'Non-Aktif' }}
                                                </span>
                                            @endif
                                        </td>
                                        @if($canManage)
                                            <td class="py-3.5 px-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <!-- Edit Button -->
                                                    <button type="button" 
                                                            @click="
                                                                editCoa = { 
                                                                    id: '{{ $coa->id }}', 
                                                                    code: '{{ $coa->code }}', 
                                                                    name: '{{ $coa->name }}', 
                                                                    type: '{{ $coa->type }}', 
                                                                    restriction_type: '{{ $coa->restriction_type }}', 
                                                                    normal_balance: '{{ $coa->normal_balance }}', 
                                                                    beginning_balance: '{{ $coa->beginning_balance }}',
                                                                    is_cash_or_bank: {{ $coa->is_cash_or_bank ? 'true' : 'false' }} 
                                                                };
                                                                editAction = '{{ route('settings.coa.update', $coa) }}';
                                                                showEditModal = true;
                                                            "
                                                            class="px-2.5 py-1.5 bg-blue-500 hover:bg-blue-600 text-white font-bold text-xs rounded-xl shadow-sm cursor-pointer transition-colors">
                                                        Ubah
                                                    </button>

                                                    <!-- Delete Button -->
                                                    @if(!$coa->journalDetails()->exists())
                                                        <form action="{{ route('settings.coa.destroy', $coa) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="px-2.5 py-1.5 bg-rose-500 hover:bg-rose-600 text-white font-bold text-xs rounded-xl shadow-sm cursor-pointer transition-colors">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-8 text-center text-slate-400 font-medium">Belum ada akun terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Right: Create/Action Form (Only visible for Super Admin/Ketua) -->
                <div class="space-y-6">
                    @if($canManage)
                        <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                            <div>
                                <h2 class="text-md font-black text-slate-900 dark:text-white tracking-tight">Tambah Rekening Baru</h2>
                                <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Buat klasifikasi COA baru dalam bagan akun regional Anda.</p>
                            </div>

                            <form action="{{ route('settings.coa.store') }}" method="POST" class="space-y-4">
                                @csrf

                                <!-- Account Code -->
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Kode Rekening</label>
                                    <input type="text" name="code" required placeholder="Contoh: 104" value="{{ old('code') }}"
                                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30">
                                </div>

                                <!-- Account Name -->
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Nama Rekening</label>
                                    <input type="text" name="name" required placeholder="Contoh: Piutang Anggota" value="{{ old('name') }}"
                                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30">
                                </div>

                                <!-- Account Type -->
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Tipe Akun (Klasifikasi)</label>
                                    <select name="type" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                        <option value="asset">Aset (Harta)</option>
                                        <option value="liability">Liabilitas (Utang/Kewajiban)</option>
                                        <option value="equity">Aset Neto (Modal/Ekuitas)</option>
                                        <option value="revenue">Pendapatan (Penerimaan)</option>
                                        <option value="expense">Beban (Pengeluaran)</option>
                                    </select>
                                </div>

                                <!-- Restriction Type (ISAK 35) -->
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Jenis Restriksi (ISAK 35)</label>
                                    <select name="restriction_type" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                        <option value="unrestricted">Tanpa Pembatasan</option>
                                        <option value="temporarily_restricted">Terikat Temporer</option>
                                        <option value="permanently_restricted">Terikat Permanen</option>
                                    </select>
                                </div>

                                <!-- Normal Balance -->
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Saldo Normal</label>
                                    <select name="normal_balance" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                        <option value="debit">Debit</option>
                                        <option value="credit">Kredit</option>
                                    </select>
                                </div>

                                <!-- Beginning Balance -->
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Saldo Awal (Rp)</label>
                                    <input type="number" name="beginning_balance" step="0.01" min="0" required placeholder="0.00" value="0.00"
                                           class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30">
                                </div>

                                <!-- Cash/Bank Flag -->
                                <div class="flex items-center gap-3 pt-2">
                                    <input type="checkbox" id="is_cash_or_bank" name="is_cash_or_bank" value="1"
                                           class="w-4 h-4 text-omni-primary border-slate-350 rounded focus:ring-omni-primary/30">
                                    <label for="is_cash_or_bank" class="text-xs font-bold text-slate-500 uppercase cursor-pointer">Kas / Instrumen Bank</label>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" class="w-full bg-omni-primary hover:bg-blue-900 text-white font-bold py-3 rounded-2xl text-xs cursor-pointer shadow-md transition-colors">
                                        Tambah Rekening
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <!-- Read Only Warning Card -->
                        <div class="bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 p-6 rounded-3xl text-xs font-bold space-y-2">
                            <span class="text-lg">🔒</span>
                            <h4 class="font-extrabold uppercase">Mode Lihat Saja</h4>
                            <p class="leading-relaxed">Anda masuk sebagai <strong>{{ $role }}</strong>. Hanya Ketua Cabang atau Super Admin yang diperbolehkan membuat, memodifikasi, atau menghapus Bagan Akun (COA).</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- AlpineJS Edit Modal -->
        <div class="fixed inset-0 z-50 overflow-y-auto" x-show="showEditModal" x-cloak>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity" 
                     @click="showEditModal = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form :action="editAction" method="POST" class="p-6 sm:p-8 space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <h3 class="text-lg font-black text-slate-900 dark:text-white">Ubah Rekening COA</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Harap sesuaikan informasi rekening di bawah ini.</p>
                        </div>

                        <!-- Account Code -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-400 uppercase">Kode Rekening</label>
                            <input type="text" name="code" required x-model="editCoa.code"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30">
                        </div>

                        <!-- Account Name -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-400 uppercase">Nama Rekening</label>
                            <input type="text" name="name" required x-model="editCoa.name"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30">
                        </div>

                        <!-- Account Type -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-400 uppercase">Tipe Akun (Klasifikasi)</label>
                            <select name="type" required x-model="editCoa.type"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                <option value="asset">Aset (Harta)</option>
                                <option value="liability">Liabilitas (Utang/Kewajiban)</option>
                                <option value="equity">Aset Neto (Modal/Ekuitas)</option>
                                <option value="revenue">Pendapatan (Penerimaan)</option>
                                <option value="expense">Beban (Pengeluaran)</option>
                            </select>
                        </div>

                        <!-- Restriction Type -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-400 uppercase">Jenis Restriksi (ISAK 35)</label>
                            <select name="restriction_type" required x-model="editCoa.restriction_type"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                <option value="unrestricted">Tanpa Pembatasan</option>
                                <option value="temporarily_restricted">Terikat Temporer</option>
                                <option value="permanently_restricted">Terikat Permanen</option>
                            </select>
                        </div>

                        <!-- Normal Balance -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-400 uppercase">Saldo Normal</label>
                            <select name="normal_balance" required x-model="editCoa.normal_balance"
                                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                <option value="debit">Debit</option>
                                <option value="credit">Kredit</option>
                            </select>
                        </div>

                        <!-- Beginning Balance -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-400 uppercase">Saldo Awal (Rp)</label>
                            <input type="number" name="beginning_balance" step="0.01" min="0" required x-model="editCoa.beginning_balance"
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30">
                        </div>

                        <!-- Cash/Bank Flag -->
                        <div class="flex items-center gap-3">
                            <input type="checkbox" id="edit_is_cash_or_bank" name="is_cash_or_bank" value="1" x-model="editCoa.is_cash_or_bank"
                                   class="w-4 h-4 text-omni-primary border-slate-350 rounded focus:ring-omni-primary/30">
                            <label for="edit_is_cash_or_bank" class="text-xs font-bold text-slate-500 uppercase cursor-pointer">Kas / Instrumen Bank</label>
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" @click="showEditModal = false" class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-700 dark:text-slate-400 cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2 bg-omni-primary hover:bg-blue-900 text-white font-bold text-xs rounded-xl shadow-sm cursor-pointer transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
