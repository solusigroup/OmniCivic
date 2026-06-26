<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Header Banner -->
            <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute top-[-50%] right-[-10%] w-96 h-96 bg-omni-primary/5 dark:bg-omni-primary/3 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex items-center gap-5 relative z-10">
                    <div class="w-14 h-14 bg-omni-primary rounded-2xl flex items-center justify-center text-white shadow-md shadow-omni-primary/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Pengaturan Identitas Cabang</h1>
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

            <!-- Authorization Banner -->
            @if($canManage)
                <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 px-6 py-4 rounded-2xl text-xs font-bold flex items-center gap-3">
                    <span class="p-1 rounded-full bg-emerald-500/20">🔓</span>
                    <span>Hak Akses Penuh: Anda memiliki wewenang Ketua Cabang / Super Admin untuk mengedit informasi identitas dan mengunggah logo.</span>
                </div>
            @else
                <div class="bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 px-6 py-4 rounded-2xl text-xs font-bold flex items-center gap-3">
                    <span class="p-1 rounded-full bg-amber-500/20">🔒</span>
                    <span>Mode Lihat Saja: Anda tidak memiliki wewenang mengubah identitas cabang ini. Hanya Ketua Cabang atau Super Admin yang dapat menyimpan perubahan.</span>
                </div>
            @endif

            <!-- Main Form -->
            <form action="{{ route('settings.branch.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @csrf

                <!-- Left Column: Details -->
                <div class="lg:col-span-2 bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                    <div>
                        <h2 class="text-lg font-black text-slate-900 dark:text-white tracking-tight">Rincian Identitas Cabang</h2>
                        <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Informasi di bawah ini digunakan pada Kop Surat laporan keuangan resmi dan dashboard.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Party Name -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase">Nama Partai Politik</label>
                            <input type="text" name="party_name" value="{{ old('party_name', $settings['party_name']) }}" 
                                   @if(!$canManage) disabled @endif required
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30 @error('party_name') border-rose-500 @enderror">
                            @error('party_name')
                                <span class="text-xs text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Branch Display Name -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase">Nama Tampilan Cabang / DPD / DPC</label>
                            <input type="text" name="branch_display_name" value="{{ old('branch_display_name', $settings['branch_display_name']) }}" 
                                   @if(!$canManage) disabled @endif required
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30 @error('branch_display_name') border-rose-500 @enderror">
                            @error('branch_display_name')
                                <span class="text-xs text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase">Nomor Telepon Resmi</label>
                            <input type="text" name="phone" value="{{ old('phone', $settings['phone']) }}" 
                                   @if(!$canManage) disabled @endif required
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30 @error('phone') border-rose-500 @enderror">
                            @error('phone')
                                <span class="text-xs text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase">Surel / Email Resmi</label>
                            <input type="email" name="email" value="{{ old('email', $settings['email']) }}" 
                                   @if(!$canManage) disabled @endif required
                                   class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30 @error('email') border-rose-500 @enderror">
                            @error('email')
                                <span class="text-xs text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase">Alamat Kantor Sekretariat</label>
                            <textarea name="address" rows="3" @if(!$canManage) disabled @endif required
                                      class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-3.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-omni-primary/30 @error('address') border-rose-500 @enderror">{{ old('address', $settings['address']) }}</textarea>
                            @error('address')
                                <span class="text-xs text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if($canManage)
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="bg-omni-primary hover:bg-blue-900 text-white font-bold px-6 py-3 rounded-2xl text-xs cursor-pointer shadow-md transition-colors">
                                Simpan Perubahan
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Logo Uploads -->
                <div class="space-y-8">
                    
                    <!-- Card 1: Logo Partai Nasional -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                        <div>
                            <h3 class="text-md font-black text-slate-900 dark:text-white tracking-tight">Logo Partai Nasional</h3>
                            <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Logo resmi partai di tingkat pusat (DPP).</p>
                        </div>

                        <!-- Logo Preview -->
                        <div class="flex flex-col items-center justify-center p-4 bg-slate-50 dark:bg-slate-955 border border-slate-200 dark:border-slate-800 rounded-2xl min-h-48 relative">
                            @if(!empty($settings['logo_party_path']))
                                <img id="party_logo_preview" src="{{ asset('storage/' . $settings['logo_party_path']) }}" alt="Logo Partai" class="max-h-36 object-contain">
                            @else
                                <div id="party_logo_svg_placeholder" class="flex flex-col items-center gap-2">
                                    <svg class="w-16 h-16 text-slate-300 dark:text-slate-700" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M50 12C32 12 20 22 20 38C20 62 50 88 50 88C50 88 80 62 80 38C80 22 68 12 50 12Z" fill="currentColor" fill-opacity="0.1"/>
                                        <path d="M50 15C34 15 22 24.5 22 39C22 61 50 85 50 85C50 85 78 61 78 39C78 24.5 66 15 50 15Z" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="50" cy="38" r="6" fill="currentColor"/>
                                    </svg>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-600 font-bold uppercase tracking-wider">Logo Bawaan</span>
                                </div>
                                <img id="party_logo_preview" class="max-h-36 object-contain hidden">
                            @endif
                        </div>

                        @if($canManage)
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase">Unggah Logo Baru</label>
                                <input type="file" id="logo_party" name="logo_party" accept="image/*" onchange="previewImage(event, 'party')"
                                       class="w-full text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 dark:file:bg-slate-800 dark:file:text-slate-300 hover:file:bg-slate-200 dark:hover:file:bg-slate-700 cursor-pointer">
                                @error('logo_party')
                                    <span class="text-xs text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Card 2: Logo Cabang / Regional -->
                    <div class="bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                        <div>
                            <h3 class="text-md font-black text-slate-900 dark:text-white tracking-tight">Logo Lokal Cabang</h3>
                            <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Logo unik regional / wilayah kerja (opsional).</p>
                        </div>

                        <!-- Logo Preview -->
                        <div class="flex flex-col items-center justify-center p-4 bg-slate-50 dark:bg-slate-955 border border-slate-200 dark:border-slate-800 rounded-2xl min-h-48 relative">
                            @if(!empty($settings['logo_branch_path']))
                                <img id="branch_logo_preview" src="{{ asset('storage/' . $settings['logo_branch_path']) }}" alt="Logo Cabang" class="max-h-36 object-contain">
                            @else
                                <div id="branch_logo_svg_placeholder" class="flex flex-col items-center gap-2">
                                    <svg class="w-16 h-16 text-slate-300 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-600 font-bold uppercase tracking-wider">Belum Ada Logo Cabang</span>
                                </div>
                                <img id="branch_logo_preview" class="max-h-36 object-contain hidden">
                            @endif
                        </div>

                        @if($canManage)
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase">Unggah Logo Baru</label>
                                <input type="file" id="logo_branch" name="logo_branch" accept="image/*" onchange="previewImage(event, 'branch')"
                                       class="w-full text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 dark:file:bg-slate-800 dark:file:text-slate-300 hover:file:bg-slate-200 dark:hover:file:bg-slate-700 cursor-pointer">
                                @error('logo_branch')
                                    <span class="text-xs text-rose-500 font-semibold block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </div>

                </div>

            </form>
        </div>
    </div>

    <!-- Client-side logo upload preview script -->
    <script>
        function previewImage(event, type) {
            const file = event.target.files[0];
            if (file) {
                const previewImg = document.getElementById(type + '_logo_preview');
                const placeholderSvg = document.getElementById(type + '_logo_svg_placeholder');
                
                previewImg.src = URL.createObjectURL(file);
                previewImg.classList.remove('hidden');
                if (placeholderSvg) {
                    placeholderSvg.classList.add('hidden');
                }
            }
        }
    </script>
</x-app-layout>
