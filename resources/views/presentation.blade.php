<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presentasi Interaktif OmniCivic - Sistem Akuntansi Parpol Modern</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0F172A; /* Omni dark */
            color: #f8fafc;
            overflow-x: hidden;
        }
        
        .bg-omni-dark { background-color: #0F172A; }
        .text-omni-success { color: #10B981; }
        .text-omni-primary { color: #1E3A8A; }
        
        /* Glowing background blobs */
        .glow-blob {
            position: absolute;
            filter: blur(120px);
            opacity: 0.15;
            pointer-events: none;
            z-index: -1;
        }
        
        .carousel-item {
            height: 80vh;
            transition: transform 0.6s ease-in-out, opacity 0.6s ease-in-out;
        }

        .slide-content {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .card-mobirise-dark {
            background: rgba(30, 41, 59, 0.5); /* slate-800 with opacity */
            border: 1px solid rgba(51, 65, 85, 0.6); /* slate-700 */
            border-radius: 24px;
            padding: 2rem;
            backdrop-filter: blur(10px);
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
            opacity: 0.8;
        }
        
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0,0,0,0.5);
            border-radius: 50%;
            padding: 1.5rem;
            background-size: 50%;
        }

        .btn-omni-success {
            background-color: #10B981;
            color: #fff;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            padding: 0.75rem 2rem;
            transition: all 0.3s;
        }
        
        .btn-omni-success:hover {
            background-color: #059669;
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 position-relative">

    <!-- Decorative Blobs -->
    <div class="glow-blob bg-primary rounded-circle" style="top: -10%; left: -5%; width: 500px; height: 500px;"></div>
    <div class="glow-blob bg-success rounded-circle" style="bottom: -10%; right: -5%; width: 600px; height: 600px;"></div>

    <!-- Header -->
    <header class="py-3 px-4 border-bottom border-secondary border-opacity-25" style="background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(10px); z-index: 10;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-shield-fill-check fs-3 text-omni-success"></i>
                <div class="lh-1">
                    <span class="fs-5 fw-bold text-white">Omni<span class="text-omni-success">Civic</span></span><br>
                    <small class="text-secondary text-uppercase fw-bold" style="font-size: 0.65rem; letter-spacing: 1px;">Interactive Presentation Deck</small>
                </div>
            </div>
            <div>
                <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm rounded-pill px-3 fw-bold"><i class="bi bi-house-door me-1"></i>Kembali ke Beranda</a>
            </div>
        </div>
    </header>

    <!-- Main Presentation Carousel -->
    <main class="flex-grow-1 position-relative">
        <div id="presentationCarousel" class="carousel slide h-100" data-bs-ride="false" data-bs-touch="true">
            
            <div class="carousel-indicators mb-0" style="bottom: -30px;">
                <button type="button" data-bs-target="#presentationCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#presentationCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#presentationCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#presentationCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>

            <div class="carousel-inner h-100">
                
                <!-- Slide 1: Intro -->
                <div class="carousel-item active">
                    <div class="slide-content text-center">
                        <div style="max-width: 800px;">
                            <span class="badge bg-success bg-opacity-10 text-success border border-success p-2 px-3 rounded-pill mb-4 text-uppercase fw-bold">
                                🚀 Re-Inovasi Akuntabilitas Sektor Publik
                            </span>
                            <h1 class="display-4 fw-bolder text-white mb-4">
                                Menghadirkan Transparansi Finansial <br>
                                <span class="text-info">Partai Politik Modern</span>
                            </h1>
                            <p class="lead text-secondary mb-5">
                                Platform SaaS Akuntansi Multidimensi Berbasis Otorisasi Bertingkat, siap menghadapi regulasi ketat KPU dan standar akuntansi non-laba nasional (ISAK 35).
                            </p>
                            <p class="small text-muted text-uppercase fw-bold tracking-widest mb-2">Geser atau tekan tombol panah untuk memulai presentasi</p>
                            <div class="d-inline-flex gap-2">
                                <button class="btn btn-omni-success rounded-circle p-3 shadow" onclick="document.querySelector('.carousel-control-next').click()">
                                    <i class="bi bi-arrow-right fs-4"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2: The Problem -->
                <div class="carousel-item">
                    <div class="slide-content">
                        <div class="w-100" style="max-width: 1000px;">
                            <div class="mb-5">
                                <span class="text-omni-success fw-bold text-uppercase small mb-2 d-block tracking-widest">01. Tantangan Sektor</span>
                                <h2 class="display-6 fw-bold text-white mb-3">Kompleksitas Keuangan Parpol</h2>
                                <p class="text-secondary">Mengapa aplikasi pembukuan akuntansi standar tidak sanggup melayani kebutuhan tata kelola partai politik?</p>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="card-mobirise-dark h-100 text-start">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                            <i class="bi bi-bank fs-4"></i>
                                        </div>
                                        <h5 class="text-white fw-bold mb-3">Kepatuhan Hukum Ketat</h5>
                                        <p class="text-secondary small mb-0">Parpol wajib tunduk pada kewajiban audit berkala oleh KAP, KPU, serta BPK terkait penggunaan bantuan dana APBN/APBD.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-mobirise-dark h-100 text-start">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                            <i class="bi bi-diagram-3 fs-4"></i>
                                        </div>
                                        <h5 class="text-white fw-bold mb-3">Hierarki Kewilayahan</h5>
                                        <p class="text-secondary small mb-0">Skala organisasi parpol berjenjang. Sangat berisiko tinggi terjadi tumpang tindih saldo dan kekacauan laporan konsolidasi.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-mobirise-dark h-100 text-start">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
                                            <i class="bi bi-person-x fs-4"></i>
                                        </div>
                                        <h5 class="text-white fw-bold mb-3">Ketidakseimbangan Otoritas</h5>
                                        <p class="text-secondary small mb-0">Input data staf akuntansi langsung merubah laporan keuangan secara sepihak, memicu manipulasi data oleh pihak internal.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 3: The Solution -->
                <div class="carousel-item">
                    <div class="slide-content">
                        <div class="w-100" style="max-width: 1000px;">
                            <div class="mb-5">
                                <span class="text-omni-success fw-bold text-uppercase small mb-2 d-block tracking-widest">02. Solusi Kami</span>
                                <h2 class="display-6 fw-bold text-white mb-3">Memperkenalkan OmniCivic</h2>
                                <p class="text-secondary">Jawaban dari segala dimensi permasalahan akuntansi di organisasi kemasyarakatan dan publik.</p>
                            </div>

                            <div class="row align-items-center g-5">
                                <div class="col-lg-6">
                                    <p class="lead text-light mb-4" style="font-size: 1.1rem;">
                                        OmniCivic menghadirkan <strong>platform SaaS cerdas</strong> yang membatasi entri transaksi hanya melalui pintu tunggal (Jurnal Kas & Bank) demi akurasi total.
                                    </p>
                                    <ul class="list-unstyled">
                                        <li class="mb-3 d-flex align-items-start gap-3">
                                            <i class="bi bi-check-circle-fill text-omni-success fs-5"></i>
                                            <span class="text-secondary">Pencatatan kas-basis harian yang disederhanakan.</span>
                                        </li>
                                        <li class="mb-3 d-flex align-items-start gap-3">
                                            <i class="bi bi-check-circle-fill text-omni-success fs-5"></i>
                                            <span class="text-secondary">Pembatasan keamanan tinggi berbasis peran (RBAC).</span>
                                        </li>
                                        <li class="mb-3 d-flex align-items-start gap-3">
                                            <i class="bi bi-check-circle-fill text-omni-success fs-5"></i>
                                            <span class="text-secondary">Multi-tenant aman untuk isolasi data regional.</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card-mobirise-dark text-start position-relative overflow-hidden">
                                        <div class="position-absolute bg-success opacity-25 rounded-circle blur-3xl" style="width: 200px; height: 200px; bottom: -50px; right: -50px; filter: blur(40px);"></div>
                                        <span class="badge bg-dark border border-secondary mb-4 p-2 text-uppercase fw-bold">Pilar Keunggulan</span>
                                        
                                        <div class="d-flex justify-content-between align-items-center bg-dark bg-opacity-50 p-3 rounded-3 mb-2 border border-secondary border-opacity-25">
                                            <span class="text-secondary small fw-medium">Akurasi Buku Besar Pembantu</span>
                                            <span class="text-omni-success fw-bold small">100% Cocok</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center bg-dark bg-opacity-50 p-3 rounded-3 mb-2 border border-secondary border-opacity-25">
                                            <span class="text-secondary small fw-medium">Kecepatan Konsolidasi</span>
                                            <span class="text-omni-success fw-bold small">&lt; 1 Detik</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center bg-dark bg-opacity-50 p-3 rounded-3 border border-secondary border-opacity-25">
                                            <span class="text-secondary small fw-medium">Kepatuhan Standar ISAK 35</span>
                                            <span class="text-omni-success fw-bold small">Ya, Terpasang</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 4: Call to Action -->
                <div class="carousel-item">
                    <div class="slide-content text-center">
                        <div style="max-width: 700px;">
                            <i class="bi bi-building-check text-omni-success" style="font-size: 5rem;"></i>
                            <h2 class="display-5 fw-bolder text-white mt-4 mb-4">
                                Siap Memodernisasi Tata Kelola Organisasi Anda?
                            </h2>
                            <p class="text-secondary lead mb-5">
                                Bergabunglah dengan OmniCivic untuk transparansi penuh, pelaporan yang mudah, dan audit yang bersih.
                            </p>
                            
                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <a href="{{ route('register') }}" class="btn btn-omni-success btn-lg rounded-pill shadow-lg">
                                    Coba Simulasi Sekarang
                                </a>
                                <a href="https://wa.me/62895399799777" class="btn btn-outline-light btn-lg rounded-pill px-4 fw-bold shadow-lg">
                                    <i class="bi bi-whatsapp me-2"></i>Hubungi Representatif
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Carousel Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#presentationCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon shadow-lg" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#presentationCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon shadow-lg" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </main>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Keyboard navigation for Carousel
        document.addEventListener('keydown', function(event) {
            const carousel = bootstrap.Carousel.getInstance(document.getElementById('presentationCarousel'));
            if (!carousel) return;
            if (event.key === 'ArrowRight' || event.key === 'Space') {
                carousel.next();
            } else if (event.key === 'ArrowLeft') {
                carousel.prev();
            }
        });
    </script>
</body>
</html>