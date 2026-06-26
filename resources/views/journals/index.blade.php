<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header Banner -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute top-[-50%] right-[-10%] w-96 h-96 bg-omni-primary/5 dark:bg-omni-primary/3 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex items-center gap-5 relative z-10">
                    <div class="w-14 h-14 bg-omni-primary rounded-2xl flex items-center justify-center text-white shadow-md shadow-omni-primary/20">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L3 7V12C3 17 7 21 12 22C17 21 21 17 21 12V7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M9 10V14" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                            <path d="M12 8V16" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                            <path d="M15 11V15" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Transaksi Kas & Bank</h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">{{ $settings['branch_display_name'] }}</p>
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

            <!-- Form Tabs & Forms Grid -->
            @if($role === 'staff' || $role === 'super_admin')
                <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6" x-data="{ activeTab: 'cash_in' }">
                    <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                        <h2 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">Input Transaksi Baru (Kas & Non-Kas)</h2>
                        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium mt-1">Silakan pilih jenis transaksi di bawah ini untuk menginput data draf jurnal.</p>
                        
                        <!-- Tabs -->
                        <div class="flex flex-wrap gap-2 mt-4">
                            <button @click="activeTab = 'cash_in'" :class="activeTab === 'cash_in' ? 'bg-omni-primary text-white shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200'" class="px-4 py-2 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                📥 Kas Masuk (Cash In)
                            </button>
                            <button @click="activeTab = 'cash_out'" :class="activeTab === 'cash_out' ? 'bg-omni-primary text-white shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200'" class="px-4 py-2 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                📤 Kas Keluar (Cash Out)
                            </button>
                            <button @click="activeTab = 'transfer'" :class="activeTab === 'transfer' ? 'bg-omni-primary text-white shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200'" class="px-4 py-2 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                🔄 Transfer Kas (Transfer)
                            </button>
                            <button @click="activeTab = 'non_cash'" :class="activeTab === 'non_cash' ? 'bg-omni-primary text-white shadow-md' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200'" class="px-4 py-2 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                📓 Jurnal Non-Kas (GL)
                            </button>
                        </div>
                    </div>

                    <!-- 1. Cash In Form -->
                    <div x-show="activeTab === 'cash_in'" x-transition>
                        <form action="{{ route('transactions.cash-in') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @csrf
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Tanggal Transaksi</label>
                                <input type="date" name="transaction_date" required value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Jumlah Uang (Rp)</label>
                                <input type="number" name="amount" step="0.01" min="0.01" required placeholder="Contoh: 1500000" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Akun Kas/Bank (Debit)</label>
                                <select name="cash_account_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    @foreach($cashAccounts as $ca)
                                        <option value="{{ $ca->id }}">{{ $ca->code }} - {{ $ca->name }} ({{ $ca->restriction_type }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Akun Pendapatan (Kredit)</label>
                                <select name="revenue_account_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    @foreach($revenueAccounts as $ra)
                                        <option value="{{ $ra->id }}">{{ $ra->code }} - {{ $ra->name }} ({{ $ra->restriction_type }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Program / Kegiatan (Opsional)</label>
                                <select name="program_id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    <option value="">-- Tanpa Program --</option>
                                    @foreach($programs as $p)
                                        <option value="{{ $p->id }}">{{ $p->code }} - {{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Divisi Pengelola (Opsional)</label>
                                <select name="division_id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    <option value="">-- Tanpa Divisi --</option>
                                    @foreach($divisions as $d)
                                        <option value="{{ $d->id }}">{{ $d->code }} - {{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Sumber Dana (Opsional - ISAK 35)</label>
                                <select name="fund_source_id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    <option value="">-- Tanpa Sumber Dana --</option>
                                    @foreach($fundSources as $fs)
                                        <option value="{{ $fs->id }}">{{ $fs->code }} - {{ $fs->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Keterangan / Deskripsi Jurnal</label>
                                <textarea name="description" rows="2" required placeholder="Tulis rincian kas masuk..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 text-sm text-slate-900 dark:text-white focus:outline-none"></textarea>
                            </div>
                            <div class="md:col-span-2 flex justify-end">
                                <button type="submit" class="bg-omni-primary hover:bg-blue-900 text-white font-bold px-6 py-3 rounded-2xl text-xs cursor-pointer shadow-md transition-colors">
                                    Simpan Kas Masuk
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- 2. Cash Out Form -->
                    <div x-show="activeTab === 'cash_out'" x-transition x-cloak>
                        <form action="{{ route('transactions.cash-out') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @csrf
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Tanggal Transaksi</label>
                                <input type="date" name="transaction_date" required value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Jumlah Uang (Rp)</label>
                                <input type="number" name="amount" step="0.01" min="0.01" required placeholder="Contoh: 500000" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Akun Kas/Bank (Kredit)</label>
                                <select name="cash_account_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    @foreach($cashAccounts as $ca)
                                        <option value="{{ $ca->id }}">{{ $ca->code }} - {{ $ca->name }} ({{ $ca->restriction_type }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Akun Pengeluaran/Beban (Debit)</label>
                                <select name="expense_account_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    @foreach($expenseAccounts as $ea)
                                        <option value="{{ $ea->id }}">{{ $ea->code }} - {{ $ea->name }} ({{ $ea->restriction_type }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Program / Kegiatan (Opsional)</label>
                                <select name="program_id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    <option value="">-- Tanpa Program --</option>
                                    @foreach($programs as $p)
                                        <option value="{{ $p->id }}">{{ $p->code }} - {{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Divisi Pengelola (Opsional)</label>
                                <select name="division_id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    <option value="">-- Tanpa Divisi --</option>
                                    @foreach($divisions as $d)
                                        <option value="{{ $d->id }}">{{ $d->code }} - {{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Sumber Dana (Opsional - ISAK 35)</label>
                                <select name="fund_source_id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    <option value="">-- Tanpa Sumber Dana --</option>
                                    @foreach($fundSources as $fs)
                                        <option value="{{ $fs->id }}">{{ $fs->code }} - {{ $fs->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Keterangan / Deskripsi Jurnal</label>
                                <textarea name="description" rows="2" required placeholder="Tulis rincian kas keluar..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 text-sm text-slate-900 dark:text-white focus:outline-none"></textarea>
                            </div>
                            <div class="md:col-span-2 flex justify-end">
                                <button type="submit" class="bg-omni-primary hover:bg-blue-900 text-white font-bold px-6 py-3 rounded-2xl text-xs cursor-pointer shadow-md transition-colors">
                                    Simpan Kas Keluar
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- 3. Transfer Form -->
                    <div x-show="activeTab === 'transfer'" x-transition x-cloak>
                        <form action="{{ route('transactions.transfer') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @csrf
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Tanggal Transaksi</label>
                                <input type="date" name="transaction_date" required value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Jumlah Transfer (Rp)</label>
                                <input type="number" name="amount" step="0.01" min="0.01" required placeholder="Contoh: 1000000" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Akun Asal (Kredit)</label>
                                <select name="origin_cash_account_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    @foreach($cashAccounts as $ca)
                                        <option value="{{ $ca->id }}">{{ $ca->code }} - {{ $ca->name }} ({{ $ca->restriction_type }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Akun Tujuan (Debit)</label>
                                <select name="destination_cash_account_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    @foreach($cashAccounts as $ca)
                                        <option value="{{ $ca->id }}">{{ $ca->code }} - {{ $ca->name }} ({{ $ca->restriction_type }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Keterangan / Rincian Transfer</label>
                                <textarea name="description" rows="2" required placeholder="Tulis alasan pemindahan kas..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 text-sm text-slate-900 dark:text-white focus:outline-none"></textarea>
                            </div>
                            <div class="md:col-span-2 flex justify-end">
                                <button type="submit" class="bg-omni-primary hover:bg-blue-900 text-white font-bold px-6 py-3 rounded-2xl text-xs cursor-pointer shadow-md transition-colors">
                                    Simpan Transfer Kas
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- 4. Non-Cash Form -->
                    <div x-show="activeTab === 'non_cash'" x-transition x-cloak>
                        <form action="{{ route('transactions.non-cash') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @csrf
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Tanggal Transaksi</label>
                                <input type="date" name="transaction_date" required value="{{ date('Y-m-d') }}" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Jumlah Nilai (Rp)</label>
                                <input type="number" name="amount" step="0.01" min="0.01" required placeholder="Contoh: 2500000" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Akun Debit (Penggunaan Dana)</label>
                                <select name="debit_account_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    @foreach($allAccounts as $acc)
                                        <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }} ({{ $acc->restriction_type }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Akun Kredit (Sumber Dana)</label>
                                <select name="credit_account_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    @foreach($allAccounts as $acc)
                                        <option value="{{ $acc->id }}">{{ $acc->code }} - {{ $acc->name }} ({{ $acc->restriction_type }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Program / Kegiatan (Opsional)</label>
                                <select name="program_id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    <option value="">-- Tanpa Program --</option>
                                    @foreach($programs as $p)
                                        <option value="{{ $p->id }}">{{ $p->code }} - {{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Divisi Pengelola (Opsional)</label>
                                <select name="division_id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    <option value="">-- Tanpa Divisi --</option>
                                    @foreach($divisions as $d)
                                        <option value="{{ $d->id }}">{{ $d->code }} - {{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Sumber Dana (Opsional - ISAK 35)</label>
                                <select name="fund_source_id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none">
                                    <option value="">-- Tanpa Sumber Dana --</option>
                                    @foreach($fundSources as $fs)
                                        <option value="{{ $fs->id }}">{{ $fs->code }} - {{ $fs->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-xs font-bold text-slate-400 uppercase">Keterangan / Deskripsi Jurnal</label>
                                <textarea name="description" rows="2" required placeholder="Tulis rincian jurnal penyesuaian non-kas..." class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 text-sm text-slate-900 dark:text-white focus:outline-none"></textarea>
                            </div>
                            <div class="md:col-span-2 flex justify-end">
                                <button type="submit" class="bg-omni-primary hover:bg-blue-900 text-white font-bold px-6 py-3 rounded-2xl text-xs cursor-pointer shadow-md transition-colors">
                                    Simpan Jurnal Non-Kas
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- List Table -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                <div>
                    <h2 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">Daftar Lengkap Jurnal Transaksi</h2>
                    <p class="text-xs text-slate-400 dark:text-slate-500 font-medium mt-1">Daftar pencatatan jurnal double-entry. Gunakan tombol status untuk melihat perkembangan persetujuan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-800 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                                <th class="py-3.5 px-4">Ref #</th>
                                <th class="py-3.5 px-4">Tanggal</th>
                                <th class="py-3.5 px-4">Deskripsi / Detail Transaksi</th>
                                <th class="py-3.5 px-4">Tipe</th>
                                <th class="py-3.5 px-4 text-right">Nilai Transaksi</th>
                                <th class="py-3.5 px-4 text-center">Status</th>
                                <th class="py-3.5 px-4 text-right">Pembuat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                            @forelse($journals as $journal)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                                    <td class="py-4 px-4 font-bold text-slate-900 dark:text-white">{{ $journal->reference_number }}</td>
                                    <td class="py-4 px-4 text-slate-500 dark:text-slate-400">{{ $journal->transaction_date->format('d/m/Y') }}</td>
                                    <td class="py-4 px-4">
                                        <div class="font-semibold text-slate-800 dark:text-slate-200">{{ $journal->description }}</div>
                                        <div class="space-y-1 mt-2 pl-3 border-l-2 border-slate-200 dark:border-slate-700">
                                            @foreach($journal->details as $d)
                                                <div class="text-xs flex items-center justify-between gap-8 text-slate-500 dark:text-slate-400">
                                                    <span>{{ $d->account->code }} - {{ $d->account->name }}</span>
                                                    <span>
                                                        @if($d->debit > 0) D: Rp {{ number_format($d->debit, 0, ',', '.') }}
                                                        @else K: Rp {{ number_format($d->credit, 0, ',', '.') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
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
                                    <td class="py-4 px-4 text-right text-xs text-slate-400 dark:text-slate-500">
                                        <span class="block font-bold">{{ $journal->creator->name }}</span>
                                        <span>Operator</span>
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

                <!-- Pagination links -->
                <div class="pt-4">
                    {{ $journals->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
