<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-3xl mx-auto px-4 space-y-6">
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Edit Role</h1>
            
            <form action="{{ route('roles.update', $role) }}" method="POST" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Role</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2" value="{{ old('name', $role->name) }}" {{ in_array($role->name, ['ketua', 'bendahara', 'staff']) ? 'readonly' : '' }}>
                    @if(in_array($role->name, ['ketua', 'bendahara', 'staff']))
                        <p class="text-[10px] text-amber-500 mt-1">Nama role bawaan sistem tidak dapat diubah, namun permissions-nya dapat disesuaikan.</p>
                    @endif
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Pilih Permissions</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($permissions as $p)
                        <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-100 dark:border-slate-800 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800">
                            <input type="checkbox" name="permissions[]" value="{{ $p->name }}" {{ in_array($p->name, $rolePermissions) ? 'checked' : '' }} class="rounded text-omni-primary focus:ring-omni-primary">
                            <span class="text-sm font-semibold">{{ $p->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                
                <div class="pt-4 flex justify-end gap-2">
                    <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-xl">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-omni-primary hover:bg-blue-900 text-white font-bold rounded-xl">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
