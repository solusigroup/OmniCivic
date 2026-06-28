<x-app-layout>
    <style>
        @media print {
            body {
                background-color: white !important;
                color: black !important;
            }
            .no-print {
                display: none !important;
            }
            .print-card {
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                background: transparent !important;
            }
            .print-table {
                color: black !important;
                border-color: black !important;
            }
        }
    </style>

    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen text-slate-800 dark:text-slate-200 print:bg-white print:text-black print:py-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Filter & Action Banner (no-print) -->
            <div class="no-print bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                <div class="absolute top-[-50%] right-[-10%] w-96 h-96 bg-omni-primary/5 dark:bg-omni-primary/3 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="flex items-center gap-5 relative z-10">
                    <div class="w-14 h-14 bg-omni-primary rounded-2xl flex items-center justify-center text-white shadow-md shadow-omni-primary/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m32 0v-2a4 4 0 00-4-4h-5a4 4 0 00-4 4v2m0-10a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Laporan Keuangan ISAK 35</h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider">{{ $branchName }}</p>
                    </div>
                </div>

                <!-- Print Button -->
                <div class="relative z-10">
                    <button onclick="window.print()" class="px-5 py-3 bg-omni-primary hover:bg-blue-900 text-white font-bold text-xs rounded-2xl shadow-md cursor-pointer flex items-center gap-2 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-3a2 2 0 00-2-2H9a2 2 0 00-2 2v3a2 2 0 002 2zm0-10V4a2 2 0 012-2h4a2 2 0 012 2v4M5 10h.01" />
                        </svg>
                        Cetak Laporan
                    </button>
                </div>
            </div>

            <!-- Tab Selection Bar (no-print) -->
            <div class="no-print flex flex-wrap gap-2">
                <a href="{{ route('reports.index', ['type' => 'cash_flow']) }}"
                   class="px-5 py-2.5 text-xs font-bold rounded-xl transition-all shadow-sm {{ $reportType === 'cash_flow' ? 'bg-omni-primary text-white shadow-md' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                    💵 Laporan Arus Kas
                </a>
                <a href="{{ route('reports.index', ['type' => 'activity']) }}"
                   class="px-5 py-2.5 text-xs font-bold rounded-xl transition-all shadow-sm {{ $reportType === 'activity' ? 'bg-omni-primary text-white shadow-md' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                    📈 Laporan Aktivitas
                </a>
                <a href="{{ route('reports.index', ['type' => 'position']) }}"
                   class="px-5 py-2.5 text-xs font-bold rounded-xl transition-all shadow-sm {{ $reportType === 'position' ? 'bg-omni-primary text-white shadow-md' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                    ⚖️ Laporan Posisi Keuangan
                </a>
            </div>

            <!-- Report Card Container -->
            <div class="print-card bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-sm space-y-8">
                
                <!-- Dynamic Kop Surat Header -->
                <x-report-header />

                <!-- Report Metadata Title -->
                <div class="text-center space-y-1 py-4 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                        @if($reportType === 'cash_flow')
                            LAPORAN ARUS KAS
                        @elseif($reportType === 'activity')
                            LAPORAN AKTIVITAS
                        @elseif($reportType === 'position')
                            LAPORAN POSISI KEUANGAN
                        @endif
                    </h2>
                    <p class="text-xs text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest">
                        @if($reportType === 'position')
                            Per 31 Desember 2026
                        @else
                            Untuk Periode yang Berakhir pada 31 Desember 2026
                        @endif
                    </p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-medium italic">(Disajikan dalam Rupiah - Standar Pelaporan ISAK 35)</p>
                </div>

                <!-- Report Content Tables -->
                <div class="overflow-x-auto">
                    @if($reportType === 'cash_flow')
                        <!-- CASH FLOW REPORT -->
                        <table class="w-full text-left border-collapse">
                            <tbody>
                                <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/10">
                                    <td class="py-3 px-4 font-bold text-slate-900 dark:text-white" colspan="2">ARUS KAS DARI AKTIVITAS OPERASI</td>
                                </tr>
                                
                                <tr>
                                    <td class="py-2.5 px-6 text-slate-700 dark:text-slate-300 font-semibold" colspan="2">Penerimaan Kas (Inflows):</td>
                                </tr>
                                @forelse($cashFlowData['receipts'] as $name => $amount)
                                    <tr class="border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-850/10">
                                        <td class="py-2 px-10 text-slate-600 dark:text-slate-400">{{ $name }}</td>
                                        <td class="py-2 px-4 text-right font-semibold text-slate-800 dark:text-slate-200">Rp {{ number_format($amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-2 px-10 text-slate-400 italic" colspan="2">Tidak ada penerimaan kas terdaftar.</td>
                                    </tr>
                                @endforelse
                                <tr class="border-b-2 border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/20">
                                    <td class="py-2.5 px-6 font-bold text-slate-700 dark:text-slate-300 text-xs">Total Penerimaan Kas</td>
                                    <td class="py-2.5 px-4 text-right font-bold text-slate-900 dark:text-white text-xs">Rp {{ number_format($cashFlowData['totalReceipts'], 0, ',', '.') }}</td>
                                </tr>

                                <tr>
                                    <td class="py-3 px-6 text-slate-700 dark:text-slate-300 font-semibold" colspan="2">Pengeluaran Kas (Outflows):</td>
                                </tr>
                                @forelse($cashFlowData['disbursements'] as $name => $amount)
                                    <tr class="border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-850/10">
                                        <td class="py-2 px-10 text-slate-600 dark:text-slate-400">{{ $name }}</td>
                                        <td class="py-2 px-4 text-right font-semibold text-rose-600 dark:text-rose-400">(Rp {{ number_format($amount, 0, ',', '.') }})</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-2 px-10 text-slate-400 italic" colspan="2">Tidak ada pengeluaran kas terdaftar.</td>
                                    </tr>
                                @endforelse
                                <tr class="border-b-2 border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/20">
                                    <td class="py-2.5 px-6 font-bold text-slate-700 dark:text-slate-300 text-xs">Total Pengeluaran Kas</td>
                                    <td class="py-2.5 px-4 text-right font-bold text-rose-600 dark:text-rose-400 text-xs">(Rp {{ number_format($cashFlowData['totalDisbursements'], 0, ',', '.') }})</td>
                                </tr>

                                <!-- Net Cash -->
                                <tr class="border-t-4 border-double border-slate-900 dark:border-slate-100 bg-slate-100/50 dark:bg-slate-850/50">
                                    <td class="py-4 px-4 text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Kenaikan (Penurunan) Neto Kas & Bank</td>
                                    <td class="py-4 px-4 text-right text-sm font-black @if($cashFlowData['netCash'] >= 0) text-emerald-600 dark:text-emerald-400 @else text-rose-600 dark:text-rose-400 @endif">
                                        Rp {{ number_format($cashFlowData['netCash'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    @elseif($reportType === 'activity')
                        <!-- ACTIVITY REPORT -->
                        <table class="w-full text-left border-collapse">
                            <tbody>
                                <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/10">
                                    <td class="py-3 px-4 font-bold text-slate-900 dark:text-white" colspan="2">PENDAPATAN, SUMBANGAN & BANTUAN</td>
                                </tr>
                                
                                <!-- Unrestricted -->
                                <tr>
                                    <td class="py-2.5 px-6 text-slate-700 dark:text-slate-300 font-semibold" colspan="2">Aset Neto Tidak Terikat (Pembatasan Internal):</td>
                                </tr>
                                @forelse($activityData['unrestrictedRev'] as $name => $amount)
                                    <tr class="border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-850/10">
                                        <td class="py-2 px-10 text-slate-600 dark:text-slate-400">{{ $name }}</td>
                                        <td class="py-2 px-4 text-right font-semibold text-slate-800 dark:text-slate-200">Rp {{ number_format($amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-2 px-10 text-slate-400 italic" colspan="2">Tidak ada pendapatan tidak terikat.</td>
                                    </tr>
                                @endforelse
                                <tr class="border-b border-slate-200 dark:border-slate-700 bg-slate-50/30 dark:bg-slate-800/5">
                                    <td class="py-2 px-6 font-bold text-slate-600 dark:text-slate-400 text-xs">Total Pendapatan Tidak Terikat</td>
                                    <td class="py-2 px-4 text-right font-bold text-slate-800 dark:text-slate-200 text-xs">Rp {{ number_format($activityData['totalUnrestrictedRev'], 0, ',', '.') }}</td>
                                </tr>

                                <!-- Restricted -->
                                <tr>
                                    <td class="py-3 px-6 text-slate-700 dark:text-slate-300 font-semibold" colspan="2">Aset Neto Terikat (Pembatasan Eksternal):</td>
                                </tr>
                                @forelse($activityData['restrictedRev'] as $name => $amount)
                                    <tr class="border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-850/10">
                                        <td class="py-2 px-10 text-slate-600 dark:text-slate-400">{{ $name }}</td>
                                        <td class="py-2 px-4 text-right font-semibold text-slate-800 dark:text-slate-200">Rp {{ number_format($amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-2 px-10 text-slate-400 italic" colspan="2">Tidak ada pendapatan terikat.</td>
                                    </tr>
                                @endforelse
                                <tr class="border-b-2 border-slate-200 dark:border-slate-700 bg-slate-50/30 dark:bg-slate-800/5">
                                    <td class="py-2 px-6 font-bold text-slate-600 dark:text-slate-400 text-xs">Total Pendapatan Terikat</td>
                                    <td class="py-2 px-4 text-right font-bold text-slate-800 dark:text-slate-200 text-xs">Rp {{ number_format($activityData['totalRestrictedRev'], 0, ',', '.') }}</td>
                                </tr>

                                <!-- Total Revenues -->
                                <tr class="border-b-2 border-slate-300 dark:border-slate-600 bg-slate-50 dark:bg-slate-800/40">
                                    <td class="py-2.5 px-6 font-bold text-slate-900 dark:text-white uppercase tracking-wider text-xs">TOTAL PENDAPATAN & SUMBANGAN</td>
                                    <td class="py-2.5 px-4 text-right font-black text-slate-900 dark:text-white text-xs">Rp {{ number_format($activityData['totalRevenues'], 0, ',', '.') }}</td>
                                </tr>

                                <!-- Expenses -->
                                <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/10">
                                    <td class="py-4 px-4 font-bold text-slate-900 dark:text-white" colspan="2">BEBAN & PENGELUARAN OPERASIONAL</td>
                                </tr>
                                @forelse($activityData['expenses'] as $name => $amount)
                                    <tr class="border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-850/10">
                                        <td class="py-2 px-10 text-slate-600 dark:text-slate-400">{{ $name }}</td>
                                        <td class="py-2 px-4 text-right font-semibold text-rose-600 dark:text-rose-400">(Rp {{ number_format($amount, 0, ',', '.') }})</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="py-2 px-10 text-slate-400 italic" colspan="2">Tidak ada beban pengeluaran terdaftar.</td>
                                    </tr>
                                @endforelse
                                <tr class="border-b-2 border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/20">
                                    <td class="py-2.5 px-6 font-bold text-slate-700 dark:text-slate-300 text-xs">Total Beban</td>
                                    <td class="py-2.5 px-4 text-right font-bold text-rose-600 dark:text-rose-400 text-xs">(Rp {{ number_format($activityData['totalExpenses'], 0, ',', '.') }})</td>
                                </tr>

                                <!-- Net Change in Net Assets -->
                                <tr class="border-t-4 border-double border-slate-900 dark:border-slate-100 bg-slate-100/50 dark:bg-slate-850/50">
                                    <td class="py-4 px-4 text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Perubahan Saldo Neto Aset Neto (Surplus/Defisit)</td>
                                    <td class="py-4 px-4 text-right text-sm font-black @if($activityData['netChange'] >= 0) text-emerald-600 dark:text-emerald-400 @else text-rose-600 dark:text-rose-400 @endif">
                                        Rp {{ number_format($activityData['netChange'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    @elseif($reportType === 'position')
                        <!-- POSITION REPORT -->
                        @php
                            $totalAssets = $positionData['totalAssets'] ?? 0;
                            $totalLiabilities = $positionData['totalLiabilities'] ?? 0;
                            $totalNetAssets = $positionData['totalNetAssets'] ?? 0;
                            
                            // Calculate current surplus dynamically to balance the double-entry equation:
                            // Assets = Liabilities + Equity (Net Assets) + Current Surplus
                            $currentSurplus = $totalAssets - $totalLiabilities - $totalNetAssets;
                            $balancedTotalNetAssets = $totalNetAssets + $currentSurplus;
                        @endphp

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 divide-y md:divide-y-0 md:divide-x divide-slate-200 dark:divide-slate-800">
                            <!-- Left Column: Assets -->
                            <div class="space-y-6">
                                <h3 class="text-md font-bold text-slate-900 dark:text-white uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 pb-2">Aset (Harta)</h3>
                                <table class="w-full text-left border-collapse">
                                    <tbody>
                                        @forelse($positionData['assets'] as $name => $balance)
                                            <tr class="border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-850/10">
                                                <td class="py-2.5 px-2 text-slate-700 dark:text-slate-300 font-medium">{{ $name }}</td>
                                                <td class="py-2.5 px-2 text-right font-bold text-slate-900 dark:text-white">Rp {{ number_format($balance, 0, ',', '.') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="py-2 px-2 text-slate-400 italic">Tidak ada saldo aset terdaftar.</td>
                                            </tr>
                                        @endforelse
                                        <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-t-2 border-slate-200 dark:border-slate-700">
                                            <td class="py-3 px-2 font-extrabold text-slate-900 dark:text-white text-xs uppercase">TOTAL ASET</td>
                                            <td class="py-3 px-2 text-right font-black text-slate-900 dark:text-white text-xs">Rp {{ number_format($totalAssets, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Right Column: Liabilities & Net Assets -->
                            <div class="space-y-6 md:pl-8 pt-6 md:pt-0">
                                <!-- Liabilities Section -->
                                <div class="space-y-4">
                                    <h3 class="text-md font-bold text-slate-900 dark:text-white uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 pb-2">Liabilitas (Kewajiban)</h3>
                                    <table class="w-full text-left border-collapse">
                                        <tbody>
                                            @forelse($positionData['liabilities'] as $name => $balance)
                                                <tr class="border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-850/10">
                                                    <td class="py-2.5 px-2 text-slate-700 dark:text-slate-300 font-medium">{{ $name }}</td>
                                                    <td class="py-2.5 px-2 text-right font-bold text-slate-900 dark:text-white">Rp {{ number_format($balance, 0, ',', '.') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="py-2 px-2 text-slate-400 italic">Tidak ada saldo liabilitas terdaftar.</td>
                                                </tr>
                                            @endforelse
                                            <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-t-2 border-slate-200 dark:border-slate-700">
                                                <td class="py-3 px-2 font-extrabold text-slate-900 dark:text-white text-xs uppercase">TOTAL LIABILITAS</td>
                                                <td class="py-3 px-2 text-right font-black text-slate-900 dark:text-white text-xs">Rp {{ number_format($totalLiabilities, 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Net Assets Section -->
                                <div class="space-y-4 pt-4">
                                    <h3 class="text-md font-bold text-slate-900 dark:text-white uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 pb-2">Aset Neto (Ekuitas/Modal)</h3>
                                    <table class="w-full text-left border-collapse">
                                        <tbody>
                                            @forelse($positionData['netAssets'] as $name => $balance)
                                                <tr class="border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-850/10">
                                                    <td class="py-2.5 px-2 text-slate-700 dark:text-slate-300 font-medium">{{ $name }}</td>
                                                    <td class="py-2.5 px-2 text-right font-bold text-slate-900 dark:text-white">Rp {{ number_format($balance, 0, ',', '.') }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="py-2 px-2 text-slate-400 italic" colspan="2">Tidak ada saldo aset neto awal.</td>
                                                </tr>
                                            @endforelse

                                            <!-- Surplus/Defisit Periode Berjalan -->
                                            <tr class="border-b border-slate-50 dark:border-slate-800/40 hover:bg-slate-50/50 dark:hover:bg-slate-850/10">
                                                <td class="py-2.5 px-2 text-slate-700 dark:text-slate-300 font-medium">Surplus / (Defisit) Periode Berjalan</td>
                                                <td class="py-2.5 px-2 text-right font-bold @if($currentSurplus >= 0) text-emerald-600 dark:text-emerald-400 @else text-rose-600 dark:text-rose-400 @endif">
                                                    Rp {{ number_format($currentSurplus, 0, ',', '.') }}
                                                </td>
                                            </tr>

                                            <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-t-2 border-slate-200 dark:border-slate-700">
                                                <td class="py-3 px-2 font-extrabold text-slate-900 dark:text-white text-xs uppercase">TOTAL ASET NETO</td>
                                                <td class="py-3 px-2 text-right font-black text-slate-900 dark:text-white text-xs">Rp {{ number_format($balancedTotalNetAssets, 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Balanced Total Summary Row -->
                                <div class="border-t-4 border-double border-slate-900 dark:border-slate-100 bg-slate-100/50 dark:bg-slate-850/50 p-4 rounded-2xl flex items-center justify-between">
                                    <span class="font-extrabold text-slate-900 dark:text-white text-xs uppercase">TOTAL LIABILITAS & ASET NETO</span>
                                    <span class="font-black text-slate-900 dark:text-white text-xs">Rp {{ number_format($totalLiabilities + $balancedTotalNetAssets, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
