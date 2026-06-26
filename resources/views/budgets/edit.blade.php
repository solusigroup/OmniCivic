<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-3xl mx-auto px-4 space-y-6">
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Edit Pagu Anggaran</h1>
            
            <form action="{{ route('budgets.update', $budget) }}" method="POST" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tahun Fiskal</label>
                    <input type="number" name="fiscal_year" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2" value="{{ old('fiscal_year', $budget->fiscal_year) }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Akun Beban (CoA)</label>
                    <select name="account_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">
                        @foreach($accounts as $acc)
                        <option value="{{ $acc->id }}" {{ $budget->account_id == $acc->id ? 'selected' : '' }}>{{ $acc->code }} - {{ $acc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Program</label>
                    <select name="program_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">
                        @foreach($programs as $prog)
                        <option value="{{ $prog->id }}" {{ $budget->program_id == $prog->id ? 'selected' : '' }}>{{ $prog->code }} - {{ $prog->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Divisi / Departemen</label>
                    <select name="division_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">
                        @foreach($divisions as $div)
                        <option value="{{ $div->id }}" {{ $budget->division_id == $div->id ? 'selected' : '' }}>{{ $div->code }} - {{ $div->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pagu Anggaran (Rp)</label>
                    <input type="number" name="amount" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2" value="{{ old('amount', floatval($budget->amount)) }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Catatan</label>
                    <textarea name="notes" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">{{ old('notes', $budget->notes) }}</textarea>
                </div>
                
                <div class="pt-4 flex justify-end gap-2">
                    <a href="{{ route('budgets.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-xl">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-omni-primary hover:bg-blue-900 text-white font-bold rounded-xl">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
