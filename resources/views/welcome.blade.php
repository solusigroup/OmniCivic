@extends('layouts.landing')

@section('title', 'OmniCivic — Platform Akuntansi & Otorisasi Multidimensi Organisasi Publik')

@section('content')
    <!-- Hero Section -->
    <section class="py-5" style="background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                
                <!-- Hero Content -->
                <div class="col-lg-7 text-center text-lg-start">
                    <span class="badge bg-omni-success bg-opacity-10 text-omni-success border border-omni-success p-2 px-3 rounded-pill mb-4 text-uppercase tracking-wide">
                        <span class="spinner-grow spinner-grow-sm text-omni-success me-1" role="status" aria-hidden="true" style="width: 0.5rem; height: 0.5rem;"></span>
                        Standar ISAK 35 & Regulasi KPU Terintegrasi
                    </span>
                    
                    <h1 class="display-4 fw-extrabold text-dark mb-4 lh-sm">
                        Satu Platform, Segala Dimensi Keuangan <span class="text-omni-primary">Organisasi Publik</span>.
                    </h1>
                    
                    <p class="lead text-secondary mb-5 fw-medium">
                        OmniCivic mendesain ulang tata kelola keuangan partai politik dengan sistem kas-basis berorientasi non-laba. Lacak program kerja, divisi pengelola, dan sumber dana dalam satu dashboard konsolidasi regional yang akuntabel.
                    </p>
                    
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                        <a href="{{ route('register') }}" class="btn btn-omni-primary btn-lg shadow-sm">
                            Mulai Simulasi Aplikasi
                        </a>
                        <a href="{{ route('presentation') }}" target="_blank" class="btn btn-omni-success btn-lg shadow-sm">
                            <i class="bi bi-projector-fill me-2"></i>Lihat Presentasi Interaktif
                        </a>
                        <a href="#fitur" class="btn btn-light btn-lg border rounded-pill fw-bold px-4">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>

                <!-- Hero Mockup Widget (Mobirise Style Card) -->
                <div class="col-lg-5">
                    <div class="card card-mobirise overflow-hidden p-0 position-relative">
                        <!-- Top Header bar -->
                        <div class="bg-light px-4 py-3 border-bottom d-flex align-items-center justify-content-between">
                            <div class="d-flex gap-2">
                                <span class="bg-danger rounded-circle" style="width: 12px; height: 12px;"></span>
                                <span class="bg-warning rounded-circle" style="width: 12px; height: 12px;"></span>
                                <span class="bg-success rounded-circle" style="width: 12px; height: 12px;"></span>
                            </div>
                            <span class="badge bg-secondary text-uppercase" style="font-size: 10px;">Monitor Kas Regional</span>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body p-4 p-md-5">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <h4 class="fw-extrabold text-dark mb-1">DPD Jawa Timur</h4>
                                    <p class="small text-muted mb-0 fw-bold">Branch ID: DPD-002</p>
                                </div>
                                <span class="badge bg-omni-success bg-opacity-10 text-omni-success border border-omni-success p-2">
                                    CONSOLIDATED
                                </span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded-4 border">
                                        <span class="small fw-bold text-muted d-block mb-1 text-uppercase" style="font-size: 11px;">Kas Konsolidasi</span>
                                        <span class="fs-5 fw-extrabold text-dark d-block">Rp 4,82 Milyar</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded-4 border">
                                        <span class="small fw-bold text-muted d-block mb-1 text-uppercase" style="font-size: 11px;">Sumbangan Terikat</span>
                                        <span class="fs-5 fw-extrabold text-omni-success d-block">Rp 1,50 Milyar</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small fw-bold text-secondary">Realisasi Baksos Ramadhan</span>
                                    <span class="small fw-extrabold text-dark">68%</span>
                                </div>
                                <div class="progress" style="height: 10px; border-radius: 10px;">
                                    <div class="progress-bar bg-omni-primary" role="progressbar" style="width: 68%; border-radius: 10px;" aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between p-3 bg-warning bg-opacity-10 rounded-4 border border-warning border-opacity-25">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-warning bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center text-warning" style="width: 40px; height: 40px;">
                                        <i class="bi bi-clock-history fs-5"></i>
                                    </div>
                                    <div>
                                        <span class="small fw-bold text-dark d-block">Persetujuan Pending</span>
                                        <span class="text-muted d-block" style="font-size: 12px;">Bantuan APBN Jurnal CI-002</span>
                                    </div>
                                </div>
                                <span class="badge bg-warning bg-opacity-25 text-dark border border-warning">REVIEWED</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Trusted Tier Badges -->
    <section class="py-4 border-top border-bottom bg-white">
        <div class="container">
            <p class="text-center small fw-bold text-muted mb-4 tracking-widest text-uppercase">
                Mendukung Hierarki Konsolidasi Nasional Hingga Kecamatan
            </p>
            <div class="row text-center g-3">
                <div class="col-6 col-md-3">
                    <div class="p-2 rounded-3 hover-bg-light transition-all">
                        <span class="small fw-extrabold text-muted">DPP PUSAT</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-2 rounded-3 hover-bg-light transition-all">
                        <span class="small fw-extrabold text-muted">DPD PROVINSI</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-2 rounded-3 hover-bg-light transition-all">
                        <span class="small fw-extrabold text-muted">DPC KABUPATEN</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="p-2 rounded-3 hover-bg-light transition-all">
                        <span class="small fw-extrabold text-muted">PAC KECAMATAN</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Value Propositions & Feature Grid -->
    <section id="fitur" class="py-5 bg-omni-light">
        <div class="container py-5">
            <div class="row justify-content-center mb-5 text-center">
                <div class="col-lg-8">
                    <h2 class="small fw-bold text-omni-primary text-uppercase mb-3">
                        Fitur Unggulan Aplikasi
                    </h2>
                    <h3 class="display-6 fw-extrabold text-dark mb-4">
                        Desain Arsitektur Modern untuk Transparansi Politik
                    </h3>
                    <p class="text-secondary fw-medium lead">
                        Kembangkan akuntabilitas organisasi dengan fitur yang dirancang khusus menyesuaikan regulasi nirlaba KPU & ISAK 35.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-4">
                    <div class="card card-mobirise h-100">
                        <div class="card-body">
                            <div class="bg-omni-primary bg-opacity-10 text-omni-primary rounded-4 d-inline-flex align-items-center justify-content-center mb-4" style="width: 60px; height: 60px;">
                                <i class="bi bi-stack fs-3"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Pelaporan Multidimensi</h4>
                            <p class="text-secondary fw-medium">
                                Catat detail jurnal transaksi keuangan dengan opsional multi-dimensional tagging: Program/Kegiatan, Divisi, dan Sumber Dana (ISAK 35) secara terpadu.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-md-4">
                    <div class="card card-mobirise h-100">
                        <div class="card-body">
                            <div class="bg-omni-success bg-opacity-10 text-omni-success rounded-4 d-inline-flex align-items-center justify-content-center mb-4" style="width: 60px; height: 60px;">
                                <i class="bi bi-shield-lock fs-3"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Dual-Gate Otorisasi Jurnal</h4>
                            <p class="text-secondary fw-medium">
                                Pengendalian internal mutakhir: Operator menginput draf jurnal, Bendahara melakukan peninjauan (reviewed), dan Ketua menyetujui (approved) untuk finalisasi laporan keuangan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-md-4">
                    <div class="card card-mobirise h-100">
                        <div class="card-body">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-4 d-inline-flex align-items-center justify-content-center mb-4" style="width: 60px; height: 60px;">
                                <i class="bi bi-diagram-3 fs-3"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Hierarki Kantor Cabang</h4>
                            <p class="text-secondary fw-medium">
                                Mendukung isolasi data regional yang kokoh. Entitas cabang mengelola entri jurnal lokal secara mandiri, sementara entitas pusat memantau laporan konsolidasi nasional secara real-time.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Alur Otorisasi Section -->
    <section id="alur" class="py-5 bg-white border-top border-bottom">
        <div class="container py-5">
            <div class="row justify-content-center mb-5 text-center">
                <div class="col-lg-8">
                    <h2 class="small fw-bold text-omni-primary text-uppercase mb-3">
                        Alur Otorisasi Berlapis
                    </h2>
                    <h3 class="display-6 fw-extrabold text-dark mb-4">
                        Sistem Kontrol Ganda untuk Integritas Data
                    </h3>
                    <p class="text-secondary fw-medium lead">
                        Proses verifikasi transaksi dirancang untuk meminimalisir kesalahan dan mencegah manipulasi data.
                    </p>
                </div>
            </div>
            
            <div class="row g-4 position-relative">
                <!-- Connective Line for Desktop (Hidden on mobile) -->
                <div class="d-none d-md-block position-absolute bg-light w-75" style="height: 4px; top: 50%; left: 12.5%; transform: translateY(-50%); z-index: 0;"></div>

                <!-- Step 1 -->
                <div class="col-md-4 position-relative z-1">
                    <div class="card card-mobirise h-100 text-center border">
                        <div class="card-body">
                            <div class="bg-white border rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-4" style="width: 80px; height: 80px;">
                                <span class="fs-3 fw-bold text-dark">1</span>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Input & Draft</h4>
                            <p class="text-secondary fw-medium small">Operator cabang mencatat transaksi ke dalam draf jurnal awal.</p>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-md-4 position-relative z-1">
                    <div class="card card-mobirise h-100 text-center border">
                        <div class="card-body">
                            <div class="bg-warning bg-opacity-10 border border-warning rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-4 text-warning" style="width: 80px; height: 80px;">
                                <i class="bi bi-search fs-2"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Review Bendahara</h4>
                            <p class="text-secondary fw-medium small">Bendahara memverifikasi kesesuaian dokumen dengan bukti fisik (Status: Reviewed).</p>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-md-4 position-relative z-1">
                    <div class="card card-mobirise h-100 text-center border">
                        <div class="card-body">
                            <div class="bg-omni-success bg-opacity-10 border border-omni-success rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-4 text-omni-success" style="width: 80px; height: 80px;">
                                <i class="bi bi-check2-all fs-2"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Approval Ketua</h4>
                            <p class="text-secondary fw-medium small">Ketua mengesahkan transaksi sehingga laporan terekap otomatis (Status: Approved).</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Regulasi Section -->
    <section id="regulasi" class="py-5 bg-omni-light">
        <div class="container py-5">
            <div class="row align-items-center g-5">
                <div class="col-md-6">
                    <h2 class="small fw-bold text-omni-success text-uppercase mb-3">
                        Kepatuhan Standar Akuntansi
                    </h2>
                    <h3 class="display-6 fw-extrabold text-dark mb-4">
                        Disusun Sesuai Regulasi KPU & ISAK 35
                    </h3>
                    <p class="text-secondary fw-medium lead mb-4">
                        OmniCivic memastikan seluruh alur pelaporan, tata kelola akun (Chart of Accounts), dan konsolidasi dana disesuaikan dengan standar akuntansi nirlaba dan regulasi pengawasan partai politik yang berlaku.
                    </p>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start gap-3 mb-3">
                            <i class="bi bi-check-circle-fill text-omni-success fs-5"></i>
                            <span class="text-dark fw-medium">Format laporan penerimaan & pengeluaran dana kampanye yang tervalidasi.</span>
                        </li>
                        <li class="d-flex align-items-start gap-3 mb-3">
                            <i class="bi bi-check-circle-fill text-omni-success fs-5"></i>
                            <span class="text-dark fw-medium">Pemisahan sumber dana (Sumbangan Mengikat vs Tidak Mengikat).</span>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <i class="bi bi-check-circle-fill text-omni-success fs-5"></i>
                            <span class="text-dark fw-medium">Jejak audit (audit trail) permanen untuk setiap pengubahan data finansial.</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="card card-mobirise position-relative z-1">
                        <!-- Decorative background glow -->
                        <div class="position-absolute w-100 h-100 bg-omni-success bg-opacity-25 rounded-circle blur-3xl" style="top: 0; left: 0; z-index: -1; filter: blur(40px);"></div>
                        
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                                <span class="fw-bold text-dark">Indikator Kepatuhan</span>
                                <span class="small fw-bold text-omni-success bg-omni-success bg-opacity-10 px-2 py-1 rounded">100% Valid</span>
                            </div>
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small text-secondary fw-medium">Kesesuaian COA ISAK 35</span>
                                    <span class="small text-dark fw-bold">Terpenuhi</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-omni-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small text-secondary fw-medium">Dual-Gate Authorization</span>
                                    <span class="small text-dark fw-bold">Terpenuhi</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-omni-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="small text-secondary fw-medium">Audit Trail System</span>
                                    <span class="small text-dark fw-bold">Terpenuhi</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-omni-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
