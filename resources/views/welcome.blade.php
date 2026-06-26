<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OmniCivic — Platform Akuntansi & Otorisasi Multidimensi Organisasi Publik</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Inline Style for AlpineJS x-cloak -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-omni-bg dark:bg-slate-950 font-sans text-slate-800 dark:text-slate-200 antialiased selection:bg-omni-primary selection:text-white transition-colors duration-300">

    <!-- Sticky Navigation Bar -->
    <header x-data="{ mobileMenuOpen: false }" class="sticky top-0 z-50 w-full border-b border-slate-200/80 dark:border-slate-800/80 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Left Branding -->
            <a href="#" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-omni-primary rounded-xl flex items-center justify-center text-white shadow-md shadow-omni-primary/20 group-hover:scale-105 transition-transform">
                    <!-- Hexagonal shield with financial green bars inside -->
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L3 7V12C3 17 7 21 12 22C17 21 21 17 21 12V7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M9 10V14" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                        <path d="M12 8V16" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                        <path d="M15 11V15" stroke="#10B981" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold text-lg tracking-tight text-slate-900 dark:text-white leading-none">OmniCivic</span>
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-medium tracking-wide">PLATFORM KEUANGAN</span>
                </div>
            </a>

            <!-- Center Navigation Links -->
            <nav class="hidden md:flex items-center gap-8">
                <a href="#fitur" class="text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-omni-primary dark:hover:text-blue-400 transition-colors">Fitur Utama</a>
                <a href="#alur" class="text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-omni-primary dark:hover:text-blue-400 transition-colors">Alur Otorisasi</a>
                <a href="#regulasi" class="text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-omni-primary dark:hover:text-blue-400 transition-colors">Sesuai Regulasi</a>
                <a href="{{ route('presentation') }}" target="_blank" class="text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-500 transition-colors flex items-center gap-1">
                    📽️ Presentasi Interaktif
                </a>
            </nav>

            <!-- Right Call to Action -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white bg-omni-primary hover:bg-blue-900 rounded-xl transition-all shadow-md shadow-omni-primary/10">
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-slate-700 dark:text-slate-200 hover:text-omni-primary dark:hover:text-blue-400 transition-colors">
                        Masuk Sistem
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white bg-omni-primary hover:bg-blue-900 rounded-xl transition-all shadow-md shadow-omni-primary/10">
                        Mulai Simulasi
                    </a>
                @endauth
            </div>

            <!-- Hamburger Button for Mobile -->
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-omni-primary hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-omni-primary" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!-- Icon when menu is closed. -->
                    <svg x-show="!mobileMenuOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Icon when menu is open. -->
                    <svg x-show="mobileMenuOpen" x-cloak class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu, show/hide based on menu state. -->
        <div x-show="mobileMenuOpen" x-cloak x-transition class="md:hidden border-t border-slate-200/80 dark:border-slate-800/80 bg-white dark:bg-slate-900 px-4 pt-2 pb-4 space-y-1 shadow-lg" id="mobile-menu">
            <a href="#fitur" @click="mobileMenuOpen = false" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-600 dark:text-slate-300 hover:text-omni-primary hover:bg-slate-50 dark:hover:bg-slate-800">Fitur Utama</a>
            <a href="#alur" @click="mobileMenuOpen = false" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-600 dark:text-slate-300 hover:text-omni-primary hover:bg-slate-50 dark:hover:bg-slate-800">Alur Otorisasi</a>
            <a href="#regulasi" @click="mobileMenuOpen = false" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-600 dark:text-slate-300 hover:text-omni-primary hover:bg-slate-50 dark:hover:bg-slate-800">Sesuai Regulasi</a>
            <a href="{{ route('presentation') }}" target="_blank" @click="mobileMenuOpen = false" class="block px-3 py-2.5 rounded-xl text-base font-bold text-emerald-600 dark:text-emerald-400 hover:bg-slate-50 dark:hover:bg-slate-800">📽️ Presentasi Interaktif</a>
            
            <div class="border-t border-slate-100 dark:border-slate-800 my-2 pt-2 flex flex-col gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full text-center px-4 py-2.5 text-base font-bold text-white bg-omni-primary hover:bg-blue-900 rounded-xl transition-all shadow-md shadow-omni-primary/10">
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="w-full text-center px-4 py-2.5 text-base font-bold text-slate-700 dark:text-slate-200 hover:text-omni-primary dark:hover:text-blue-400 transition-colors">
                        Masuk Sistem
                    </a>
                    <a href="{{ route('register') }}" class="w-full text-center px-4 py-2.5 text-base font-bold text-white bg-omni-primary hover:bg-blue-900 rounded-xl transition-all shadow-md shadow-omni-primary/10">
                        Mulai Simulasi
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden py-20 lg:py-28 bg-gradient-to-b from-white to-omni-bg dark:from-slate-900 dark:to-slate-950">
        <!-- Background Blur Gradients -->
        <div class="absolute top-1/4 left-1/10 w-96 h-96 bg-omni-primary/10 dark:bg-omni-primary/5 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-1/4 right-1/10 w-96 h-96 bg-omni-success/10 dark:bg-omni-success/5 rounded-full blur-3xl -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Hero Content -->
                <div class="lg:col-span-7 space-y-6 text-left">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-bold bg-omni-success/15 text-omni-success border border-omni-success/20 tracking-wide uppercase">
                        <span class="w-1.5 h-1.5 bg-omni-success rounded-full animate-ping"></span>
                        Standar ISAK 35 & Regulasi KPU Terintegrasi
                    </span>
                    
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 dark:text-white leading-[1.1] tracking-tight">
                        Satu Platform, Segala Dimensi Keuangan <span class="text-omni-primary dark:text-blue-400">Organisasi Publik</span>.
                    </h1>
                    
                    <p class="text-lg text-slate-600 dark:text-slate-300 leading-relaxed font-medium">
                        OmniCivic mendesain ulang tata kelola keuangan partai politik dengan sistem kas-basis berorientasi non-laba. Lacak program kerja, divisi pengelola, dan sumber dana dalam satu dashboard konsolidasi regional yang akuntabel.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-4 pt-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3.5 text-base font-bold text-white bg-omni-primary hover:bg-blue-900 rounded-xl shadow-lg shadow-omni-primary/20 hover:shadow-xl hover:shadow-omni-primary/30 transition-all duration-300">
                            Mulai Simulasi Aplikasi
                        </a>
                        <a href="{{ route('presentation') }}" target="_blank" class="inline-flex items-center justify-center px-6 py-3.5 text-base font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-lg shadow-emerald-600/20 hover:shadow-xl hover:shadow-emerald-600/30 transition-all duration-300">
                            📽️ Lihat Presentasi Interaktif
                        </a>
                        <a href="#fitur" class="inline-flex items-center justify-center px-6 py-3.5 text-base font-bold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-300 dark:border-slate-700 rounded-xl transition-all duration-300">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>

                <!-- Hero Mockup Widget -->
                <div class="lg:col-span-5 relative">
                    <div class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200/60 dark:border-slate-800 overflow-hidden transform hover:-translate-y-2 transition-transform duration-500">
                        <!-- Top Header bar -->
                        <div class="bg-slate-50 dark:bg-slate-850 px-6 py-4 border-b border-slate-200/60 dark:border-slate-800 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-rose-500 rounded-full"></span>
                                <span class="w-3 h-3 bg-amber-500 rounded-full"></span>
                                <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                            </div>
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400">MONITOR KAS REGIONAL</span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 space-y-6">
                            <!-- Branch Title -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-extrabold text-lg text-slate-900 dark:text-white">DPD Jawa Timur</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">Branch ID: DPD-002</p>
                                </div>
                                <span class="px-2.5 py-1 text-[10px] font-bold bg-omni-success/10 text-omni-success rounded-lg border border-omni-success/20 uppercase tracking-wider">
                                    CONSOLIDATED
                                </span>
                            </div>

                            <!-- Figures -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-200/50 dark:border-slate-800">
                                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block tracking-wider uppercase">Kas Konsolidasi</span>
                                    <span class="text-base font-extrabold text-slate-900 dark:text-white mt-1 block">Rp 4,82 Milyar</span>
                                </div>
                                <div class="bg-slate-50 dark:bg-slate-800/40 p-4 rounded-2xl border border-slate-200/50 dark:border-slate-800">
                                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 block tracking-wider uppercase">Sumbangan Terikat</span>
                                    <span class="text-base font-extrabold text-omni-success mt-1 block">Rp 1,50 Milyar</span>
                                </div>
                            </div>

                            <!-- Progress Bars -->
                            <div class="space-y-3">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-bold text-slate-700 dark:text-slate-300">Realisasi Baksos Ramadhan</span>
                                    <span class="font-extrabold text-slate-900 dark:text-white">68%</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2.5 rounded-full overflow-hidden">
                                    <div class="bg-gradient-to-r from-omni-primary to-omni-success h-full rounded-full" style="width: 68%"></div>
                                </div>
                            </div>

                            <!-- Pending Badge and Action status -->
                            <div class="flex items-center justify-between p-3.5 bg-omni-pending/10 dark:bg-omni-pending/5 rounded-2xl border border-omni-pending/20">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-omni-pending/20 flex items-center justify-center text-omni-pending">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 block">Persetujuan Pending</span>
                                        <span class="text-[10px] text-slate-500 dark:text-slate-400 block font-medium">Bantuan APBN Jurnal CI-002</span>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold bg-omni-pending/20 text-omni-pending px-2 py-0.5 rounded-md tracking-wide uppercase">
                                    REVIEWED
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Trusted Tier Badges -->
    <section class="py-8 bg-white dark:bg-slate-900 border-y border-slate-200/60 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-xs font-bold text-slate-400 dark:text-slate-500 tracking-widest uppercase mb-6">
                MENDUKUNG HIERARKI KONSOLIDASI NASIONAL HINGGA KECAMATAN
            </p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-center text-center">
                <div class="group py-3 px-4 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors duration-300">
                    <span class="text-sm font-extrabold text-slate-400 dark:text-slate-500 group-hover:text-omni-primary dark:group-hover:text-blue-400 transition-colors">
                        DPP PUSAT
                    </span>
                </div>
                <div class="group py-3 px-4 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors duration-300">
                    <span class="text-sm font-extrabold text-slate-400 dark:text-slate-500 group-hover:text-omni-primary dark:group-hover:text-blue-400 transition-colors">
                        DPD PROVINSI
                    </span>
                </div>
                <div class="group py-3 px-4 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors duration-300">
                    <span class="text-sm font-extrabold text-slate-400 dark:text-slate-500 group-hover:text-omni-primary dark:group-hover:text-blue-400 transition-colors">
                        DPC KABUPATEN
                    </span>
                </div>
                <div class="group py-3 px-4 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors duration-300">
                    <span class="text-sm font-extrabold text-slate-400 dark:text-slate-500 group-hover:text-omni-primary dark:group-hover:text-blue-400 transition-colors">
                        PAC KECAMATAN
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Value Propositions & Feature Grid -->
    <section id="fitur" class="py-20 lg:py-28 bg-omni-bg dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
            <div class="max-w-3xl mx-auto space-y-4">
                <h2 class="text-xs font-bold text-omni-primary dark:text-blue-400 uppercase tracking-widest">
                    FITUR UNGGULAN APLIKASI
                </h2>
                <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Desain Arsitektur Modern untuk Transparansi Politik
                </h3>
                <p class="text-slate-600 dark:text-slate-400 font-medium">
                    Kembangkan akuntabilitas organisasi dengan fitur yang dirancang khusus menyesuaikan regulasi nirlaba KPU & ISAK 35.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200/60 dark:border-slate-800 text-left space-y-4 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-omni-primary/10 dark:bg-omni-primary/5 text-omni-primary dark:text-blue-400 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white">Pelaporan Multidimensi</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                        Catat detail jurnal transaksi keuangan dengan opsional multi-dimensional tagging: Program/Kegiatan, Divisi, dan Sumber Dana (ISAK 35) secara terpadu.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200/60 dark:border-slate-800 text-left space-y-4 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-omni-success/10 dark:bg-omni-success/5 text-omni-success flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white">Dual-Gate Otorisasi Jurnal</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                        Pengendalian internal mutakhir: Operator menginput draf jurnal, Bendahara melakukan peninjauan (reviewed), dan Ketua menyetujui (approved) untuk finalisasi laporan keuangan.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200/60 dark:border-slate-800 text-left space-y-4 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 dark:bg-amber-500/5 text-amber-500 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white">Hierarki Kantor Cabang</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                        Mendukung isolasi data regional yang kokoh. Entitas cabang mengelola entri jurnal lokal secara mandiri, sementara entitas pusat memantau laporan konsolidasi nasional secara real-time.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Alur Otorisasi Section -->
    <section id="alur" class="py-20 lg:py-28 bg-white dark:bg-slate-900 border-y border-slate-200/60 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-12">
            <div class="max-w-3xl mx-auto space-y-4">
                <h2 class="text-xs font-bold text-omni-primary dark:text-blue-400 uppercase tracking-widest">
                    ALUR OTORISASI BERLAPIS
                </h2>
                <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Sistem Kontrol Ganda untuk Integritas Data
                </h3>
                <p class="text-slate-600 dark:text-slate-400 font-medium">
                    Proses verifikasi transaksi dirancang untuk meminimalisir kesalahan dan mencegah manipulasi data.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                <!-- Connective Line -->
                <div class="hidden md:block absolute top-1/2 left-[16.66%] right-[16.66%] h-0.5 bg-slate-200 dark:bg-slate-800 -translate-y-1/2 z-0"></div>

                <!-- Step 1 -->
                <div class="relative z-10 bg-slate-50 dark:bg-slate-800/50 p-8 rounded-3xl border border-slate-200/60 dark:border-slate-800 hover:border-omni-primary/50 transition-colors">
                    <div class="w-16 h-16 mx-auto bg-white dark:bg-slate-900 rounded-full flex items-center justify-center text-2xl font-bold text-slate-900 dark:text-white shadow-sm border border-slate-200 dark:border-slate-700 mb-6">
                        1
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Input & Draft</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Operator cabang mencatat transaksi ke dalam draf jurnal awal.</p>
                </div>

                <!-- Step 2 -->
                <div class="relative z-10 bg-slate-50 dark:bg-slate-800/50 p-8 rounded-3xl border border-slate-200/60 dark:border-slate-800 hover:border-omni-pending/50 transition-colors">
                    <div class="w-16 h-16 mx-auto bg-omni-pending/10 dark:bg-omni-pending/5 rounded-full flex items-center justify-center text-omni-pending shadow-sm border border-omni-pending/20 mb-6">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Review Bendahara</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Bendahara memverifikasi kesesuaian dokumen dengan bukti fisik (Status: Reviewed).</p>
                </div>

                <!-- Step 3 -->
                <div class="relative z-10 bg-slate-50 dark:bg-slate-800/50 p-8 rounded-3xl border border-slate-200/60 dark:border-slate-800 hover:border-omni-success/50 transition-colors">
                    <div class="w-16 h-16 mx-auto bg-omni-success/10 dark:bg-omni-success/5 rounded-full flex items-center justify-center text-omni-success shadow-sm border border-omni-success/20 mb-6">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Approval Ketua</h4>
                    <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Ketua mengesahkan transaksi sehingga laporan terekap otomatis (Status: Approved).</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Regulasi Section -->
    <section id="regulasi" class="py-20 lg:py-28 bg-gradient-to-b from-omni-bg to-white dark:from-slate-950 dark:to-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2 space-y-6">
                    <h2 class="text-xs font-bold text-omni-success uppercase tracking-widest">
                        KEPATUHAN STANDAR AKUNTANSI
                    </h2>
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Disusun Sesuai Regulasi KPU & ISAK 35
                    </h3>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                        OmniCivic memastikan seluruh alur pelaporan, tata kelola akun (Chart of Accounts), dan konsolidasi dana disesuaikan dengan standar akuntansi nirlaba dan regulasi pengawasan partai politik yang berlaku.
                    </p>
                    <ul class="space-y-4 pt-4">
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-omni-success flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">Format laporan penerimaan & pengeluaran dana kampanye yang tervalidasi.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-omni-success flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">Pemisahan sumber dana (Sumbangan Mengikat vs Tidak Mengikat).</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-omni-success flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">Jejak audit (audit trail) permanen untuk setiap pengubahan data finansial.</span>
                        </li>
                    </ul>
                </div>
                <div class="md:w-1/2 w-full relative">
                    <div class="absolute inset-0 bg-omni-success/20 blur-3xl rounded-full -z-10"></div>
                    <div class="bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 rounded-3xl p-8 shadow-2xl">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4 mb-4">
                            <span class="font-bold text-slate-800 dark:text-slate-200">Indikator Kepatuhan</span>
                            <span class="text-sm font-bold text-omni-success">100% Valid</span>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-slate-600 dark:text-slate-400 font-medium">Kesesuaian COA ISAK 35</span>
                                    <span class="text-slate-800 dark:text-slate-200 font-bold">Terpenuhi</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-omni-success h-full" style="width: 100%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-slate-600 dark:text-slate-400 font-medium">Dual-Gate Authorization</span>
                                    <span class="text-slate-800 dark:text-slate-200 font-bold">Terpenuhi</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-omni-success h-full" style="width: 100%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-slate-600 dark:text-slate-400 font-medium">Audit Trail System</span>
                                    <span class="text-slate-800 dark:text-slate-200 font-bold">Terpenuhi</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                    <div class="bg-omni-success h-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Compliant Footer -->
    <footer class="bg-slate-900 dark:bg-slate-950 text-slate-400 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <!-- Footer logo -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center text-white">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L3 7V12C3 17 7 21 12 22C17 21 21 17 21 12V7L12 2Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M9 11L11 13L15 9" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-white text-lg tracking-tight">OmniCivic</span>
                </div>

                <!-- Copyright -->
                <div class="text-xs font-medium space-y-1.5 md:text-right">
                    <p>
                        &copy; 2026 OmniCivic. Hak Cipta Dilindungi Undang-Undang.
                    </p>
                    <p class="text-[10px] text-slate-500">
                        Dikembangkan oleh <span class="font-bold text-slate-400">Kurniawan</span> (System Analyst).
                    </p>
                    <p class="text-[10px] text-slate-500">
                        OmniCivic adalah produk dari <a href="https://simpleakunting.id" target="_blank" rel="noopener noreferrer" class="text-omni-primary dark:text-blue-400 hover:underline font-bold transition-colors">SimpleAkunting.id</a>.
                    </p>
                </div>
            </div>

            <div class="border-t border-slate-800/80 pt-6 text-center">
                <p class="text-[10px] text-slate-500 leading-relaxed max-w-4xl mx-auto font-medium">
                    Pernyataan Kepatuhan: Platform OmniCivic dikonfigurasi secara ketat untuk mematuhi regulasi keuangan Partai Politik di Republik Indonesia, merujuk pada standar pelaporan organisasi non-laba (Ikatan Akuntan Indonesia - ISAK 35) dan pedoman audit transparansi Komisi Pemilihan Umum (KPU).
                </p>
            </div>
        </div>
    </footer>

</body>
</html>
