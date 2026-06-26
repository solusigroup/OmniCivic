<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-black text-slate-900 dark:text-white">Manajemen Aset Tetap</h1>
                <a href="{{ route('assets.create') }}" class="px-4 py-2 bg-omni-primary hover:bg-blue-900 text-white font-bold rounded-xl">Tambah Aset</a>
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
                            <th class="py-3.5 px-4">Kode Aset</th>
                            <th class="py-3.5 px-4">Nama Aset</th>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4">Harga Beli</th>
                            <th class="py-3.5 px-4">Cabang</th>
                            <th class="py-3.5 px-4">Kondisi</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                        @foreach($assets as $asset)
                        <tr>
                            <td class="py-4 px-4 font-bold">{{ $asset->asset_code }}</td>
                            <td class="py-4 px-4">{{ $asset->name }}</td>
                            <td class="py-4 px-4">{{ $asset->category }}</td>
                            <td class="py-4 px-4">Rp {{ number_format($asset->purchase_price, 0, ',', '.') }}</td>
                            <td class="py-4 px-4">{{ $asset->branch ? $asset->branch->name : 'Pusat' }}</td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 text-[10px] font-bold rounded uppercase 
                                    @if($asset->condition === 'good') bg-emerald-100 text-emerald-800
                                    @elseif($asset->condition === 'fair') bg-amber-100 text-amber-800
                                    @else bg-rose-100 text-rose-800
                                    @endif">
                                    {{ $asset->condition }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right flex justify-end gap-2">
                                <a href="{{ route('assets.edit', $asset) }}" class="px-3 py-1.5 bg-amber-500 text-white font-bold rounded-xl">Edit</a>
                                <form action="{{ route('assets.destroy', $asset) }}" method="POST" onsubmit="return confirm('Yakin hapus aset ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-500 text-white font-bold rounded-xl">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $assets->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
