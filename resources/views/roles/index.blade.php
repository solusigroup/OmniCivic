<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-black text-slate-900 dark:text-white">Manajemen Role</h1>
                <a href="{{ route('roles.create') }}" class="px-4 py-2 bg-omni-primary hover:bg-blue-900 text-white font-bold rounded-xl">Tambah Role</a>
            </div>

            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/25 text-emerald-500 px-5 py-4 rounded-2xl text-sm font-semibold">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-500/10 border border-rose-500/25 text-rose-500 px-5 py-4 rounded-2xl text-sm font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-sm overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 text-xs font-bold text-slate-400 uppercase">
                            <th class="py-3.5 px-4">Nama Role</th>
                            <th class="py-3.5 px-4">Permissions</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                        @foreach($roles as $r)
                        <tr>
                            <td class="py-4 px-4 font-bold uppercase text-omni-primary">{{ $r->name }}</td>
                            <td class="py-4 px-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($r->permissions as $p)
                                        <span class="px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[10px] font-bold rounded">{{ $p->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="py-4 px-4 text-right flex justify-end gap-2">
                                @if($r->name !== 'super_admin')
                                <a href="{{ route('roles.edit', $r) }}" class="px-3 py-1.5 bg-amber-500 text-white font-bold rounded-xl">Edit</a>
                                    @if(!in_array($r->name, ['ketua', 'bendahara', 'staff']))
                                    <form action="{{ route('roles.destroy', $r) }}" method="POST" onsubmit="return confirm('Yakin hapus role ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-500 text-white font-bold rounded-xl">Hapus</button>
                                    </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
