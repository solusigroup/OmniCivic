<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-3xl mx-auto px-4 space-y-6">
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Edit Pengguna</h1>
            
            <form action="{{ route('users.update', $user) }}" method="POST" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama</label>
                    <input type="text" name="name" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2" value="{{ old('name', $user->name) }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Email</label>
                    <input type="email" name="email" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2" value="{{ old('email', $user->email) }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Password (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Role</label>
                    <select name="role" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->role == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Cabang (Kosongkan jika pusat)</label>
                    <select name="branch_id" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">
                        <option value="">Pusat / Global</option>
                        @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ $user->branch_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status</label>
                    <select name="status" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2">
                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                
                <div class="pt-4 flex justify-end gap-2">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 font-bold rounded-xl">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-omni-primary hover:bg-blue-900 text-white font-bold rounded-xl">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
