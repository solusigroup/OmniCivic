<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex flex-col items-center mb-8">
        <!-- Brand Logo -->
        <a href="/" class="flex items-center gap-2.5 mb-6 group">
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

        <!-- Glowing Profile Avatar -->
        <div class="relative mt-2">
            <div class="w-28 h-28 rounded-full border-4 border-blue-500/20 p-1 bg-[#020813] shadow-[0_0_25px_rgba(59,130,246,0.4)]">
                <div class="w-full h-full rounded-full overflow-hidden border-2 border-blue-400/80">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=150&h=150" alt="Avatar" class="w-full h-full object-cover grayscale brightness-90 contrast-110">
                </div>
            </div>
            <!-- Dynamic Active Status Glow Dot -->
            <span class="absolute bottom-1 right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-[#030c20] shadow-[0_0_10px_#10B981]"></span>
        </div>
    </div>

    <!-- Title -->
    <h2 class="text-2xl font-bold text-white mb-6 text-left tracking-wide">Login</h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email/Username -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-400/60">
                <!-- User Icon (Username) -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <input id="email" class="block w-full bg-[#05112c]/60 border border-blue-500/25 rounded-full py-3.5 pl-12 pr-6 text-sm text-white placeholder-blue-300/40 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all outline-none" 
                   type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Username / Email" />
            
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-rose-400 px-4" />
        </div>

        <!-- Password -->
        <div class="relative" x-data="{ showPassword: false }">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-blue-400/60">
                <!-- Lock Icon -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <input id="password" class="block w-full bg-[#05112c]/60 border border-blue-500/25 rounded-full py-3.5 pl-12 pr-12 text-sm text-white placeholder-blue-300/40 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 transition-all outline-none" 
                   :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Password" />
            
            <!-- Hide/Reveal Toggle Button -->
            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-blue-400/60 hover:text-blue-300 transition-colors focus:outline-none">
                <!-- Eye Icon (Show) -->
                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                <!-- Eye Off Icon (Hide) -->
                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                </svg>
            </button>
            
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-rose-400 px-4" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-xs px-2 pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-blue-500/30 bg-[#05112c]/60 text-blue-600 focus:ring-0 focus:ring-offset-0 transition-colors">
                <span class="ms-2 text-blue-300/70 hover:text-blue-300 transition-colors">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-blue-400 hover:text-blue-300 transition-colors font-medium" href="{{ route('password.request') }}">
                    Forgot Password
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold py-4 rounded-full transition-all shadow-[0_0_20px_rgba(59,130,246,0.4)] hover:shadow-[0_0_30px_rgba(59,130,246,0.7)] cursor-pointer text-center tracking-wider outline-none focus:ring-2 focus:ring-blue-400/30">
                Sign in
            </button>
        </div>
    </form>

    <!-- Bottom Sign Up -->
    <div class="mt-8 text-center text-xs">
        <span class="text-blue-300/60">Don't have account?</span>
        <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-bold ml-1 transition-colors">
            Sign up
        </a>
    </div>
</x-guest-layout>
