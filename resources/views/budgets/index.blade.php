<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-white">Penganggaran (Budgeting)</h1>
                    <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Tahun Fiskal: {{ $year }} &bull; Total Anggaran: Rp {{ number_format($totalBudget, 0, ',', '.') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <form action="{{ route('budgets.index') }}" method="GET" class="flex items-center gap-2">
                        <select name="year" onchange="this.form.submit()" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-sm font-bold shadow-sm">
                            @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++)
                                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>Tahun {{ $i }}</option>
                            @endfor
                        </select>
                    </form>
                    <a href="{{ route('budgets.create') }}" class="px-4 py-2 bg-omni-primary hover:bg-blue-900 text-white font-bold rounded-xl shadow-sm text-sm">Buat Anggaran</a>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/25 text-emerald-500 px-5 py-4 rounded-2xl text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 text-xs font-bold text-slate-400 uppercase">
                            <th class="py-3.5 px-4">CoA / Akun Beban</th>
                            <th class="py-3.5 px-4">Program</th>
                            <th class="py-3.5 px-4">Divisi</th>
                            <th class="py-3.5 px-4 text-right">Pagu Anggaran</th>
                            <th class="py-3.5 px-4">Catatan</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                        @forelse($budgets as $budget)
                        <tr>
                            <td class="py-4 px-4 font-bold text-omni-primary">{{ $budget->account->code }} - {{ $budget->account->name }}</td>
                            <td class="py-4 px-4 font-semibold">{{ $budget->program->name }}</td>
                            <td class="py-4 px-4 text-slate-500">{{ $budget->division->name }}</td>
                            <td class="py-4 px-4 text-right font-black">Rp {{ number_format($budget->amount, 0, ',', '.') }}</td>
                            <td class="py-4 px-4 text-xs">{{ $budget->notes ?: '-' }}</td>
                            <td class="py-4 px-4 text-right flex justify-end gap-2">
                                <a href="{{ route('budgets.edit', $budget) }}" class="px-3 py-1.5 bg-amber-500 text-white font-bold rounded-xl text-[10px] uppercase">Edit</a>
                                <form action="{{ route('budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Yakin hapus anggaran ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-500 text-white font-bold rounded-xl text-[10px] uppercase">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 font-medium">Belum ada pagu anggaran untuk tahun {{ $year }}.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $budgets->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
