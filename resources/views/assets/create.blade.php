<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-3xl mx-auto px-4 space-y-6">
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Tambah Aset</h1>
            
            <form action="{{ route('assets.store') }}" method="POST" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kode Aset</label>
                    <input type="text" name="asset_code" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2" value="{{ old('asset_code') }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Aset</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2" value="{{ old('name') }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kategori</label>
                    <input type="text" name="category" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2" value="{{ old('category') }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Pembelian</label>
                    <input type="date" name="purchase_date" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2" value="{{ old('purchase_date') }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Harga Beli</label>
                    <input type="number" name="purchase_price" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2" value="{{ old('purchase_price') }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Kondisi</label>
                    <select name="condition" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">
                        <option value="good">Baik</option>
                        <option value="fair">Cukup</option>
                        <option value="poor">Buruk</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Cabang</label>
                    <select name="branch_id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">
                        <option value="">Pusat / Global</option>
                        @foreach($branches as $b)
                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Catatan</label>
                    <textarea name="notes" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">{{ old('notes') }}</textarea>
                </div>
                
                <div class="pt-4 flex justify-end gap-2">
                    <a href="{{ route('assets.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-xl">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-omni-primary hover:bg-blue-900 text-white font-bold rounded-xl">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
