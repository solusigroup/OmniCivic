<x-guest-layout>
    <div class="flex flex-col items-center mb-6">
        <!-- Brand Logo -->
        <a href="/" class="flex items-center gap-2.5 mb-4 group">
            <div class="w-9 h-9 bg-omni-primary rounded-xl flex items-center justify-center text-white shadow-md shadow-omni-primary/20 group-hover:scale-105 transition-transform">
                <svg class="w-5.5 h-5.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L3 7V12C3 17 7 21 12 22C17 21 21 17 21 12V7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                    <path d="M9 10V14" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                    <path d="M12 8V16" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                    <path d="M15 11V15" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="flex flex-col text-left">
                <span class="font-extrabold text-base tracking-tight text-white leading-none">OmniCivic</span>
                <span class="text-[9px] text-blue-300 font-semibold tracking-wider">PLATFORM KEUANGAN</span>
            </div>
        </a>

        <!-- Glowing User Plus Icon Circle -->
        <div class="relative mt-1">
            <div class="w-24 h-24 rounded-full border-4 border-blue-500/20 p-1 bg-[#020813] shadow-[0_0_25px_rgba(59,130,246,0.4)] flex items-center justify-center">
                <div class="w-full h-full rounded-full overflow-hidden border-2 border-blue-400/80 flex items-center justify-center bg-blue-950/30 text-blue-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Title -->
    <h2 class="text-2xl font-bold text-white mb-5 text-left tracking-wide">Daftar Akun</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-400/60">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <input id="name" class="block w-full bg-[#05112c]/60 border border-blue-500/25 rounded-full py-3 pl-11 pr-5 text-sm text-white placeholder-blue-300/40 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all outline-none" 
                   type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap" />
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-400 px-4" />
        </div>

        <!-- Email Address -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-400/60">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <input id="email" class="block w-full bg-[#05112c]/60 border border-blue-500/25 rounded-full py-3 pl-11 pr-5 text-sm text-white placeholder-blue-300/40 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all outline-none" 
                   type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Alamat Email" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-400 px-4" />
        </div>

        <!-- Password -->
        <div class="relative" x-data="{ showPassword: false }">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-400/60">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <input id="password" class="block w-full bg-[#05112c]/60 border border-blue-500/25 rounded-full py-3 pl-11 pr-11 text-sm text-white placeholder-blue-300/40 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all outline-none" 
                   :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder="Password" />
            
            <!-- Hide/Reveal Toggle Button -->
            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-blue-400/60 hover:text-blue-300 transition-colors focus:outline-none">
                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
            </button>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-400 px-4" />
        </div>

        <!-- Confirm Password -->
        <div class="relative" x-data="{ showConfirmPassword: false }">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-400/60">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <input id="password_confirmation" class="block w-full bg-[#05112c]/60 border border-blue-500/25 rounded-full py-3 pl-11 pr-11 text-sm text-white placeholder-blue-300/40 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all outline-none" 
                   :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi Password" />
            
            <!-- Hide/Reveal Toggle Button -->
            <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-blue-400/60 hover:text-blue-300 transition-colors focus:outline-none">
                <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <svg x-show="showConfirmPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
            </button>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-rose-400 px-4" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold py-3.5 rounded-full transition-all shadow-[0_0_20px_rgba(59,130,246,0.4)] hover:shadow-[0_0_30px_rgba(59,130,246,0.7)] cursor-pointer text-center tracking-wider outline-none focus:ring-2 focus:ring-blue-400/30">
                Daftar Akun
            </button>
        </div>
    </form>

    <!-- Bottom Sign In -->
    <div class="mt-6 text-center text-xs">
        <span class="text-blue-300/60">Sudah memiliki akun?</span>
        <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-bold ml-1 transition-colors">
            Masuk
        </a>
    </div>
</x-guest-layout>
