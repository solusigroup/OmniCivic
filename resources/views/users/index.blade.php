<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-black text-slate-900 dark:text-white">Manajemen Pengguna</h1>
                <a href="{{ route('users.create') }}" class="px-4 py-2 bg-omni-primary hover:bg-blue-900 text-white font-bold rounded-xl">Tambah Pengguna</a>
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
                            <th class="py-3.5 px-4">Nama</th>
                            <th class="py-3.5 px-4">Email</th>
                            <th class="py-3.5 px-4">Role</th>
                            <th class="py-3.5 px-4">Cabang</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                        @foreach($users as $u)
                        <tr>
                            <td class="py-4 px-4 font-bold">{{ $u->name }}</td>
                            <td class="py-4 px-4">{{ $u->email }}</td>
                            <td class="py-4 px-4 uppercase font-semibold text-omni-primary">{{ $u->role }}</td>
                            <td class="py-4 px-4">{{ $u->branch ? $u->branch->name : 'Pusat/Global' }}</td>
                            <td class="py-4 px-4">
                                <span class="px-2 py-1 text-[10px] font-bold rounded uppercase {{ $u->status == 'active' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    {{ $u->status }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-right flex justify-end gap-2">
                                <a href="{{ route('users.edit', $u) }}" class="px-3 py-1.5 bg-amber-500 text-white font-bold rounded-xl">Edit</a>
                                @if($u->id !== 999999)
                                <form action="{{ route('users.destroy', $u) }}" method="POST" onsubmit="return confirm('Yakin hapus pengguna ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-500 text-white font-bold rounded-xl">Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
