<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'OmniCivic')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .btn-omni-success {
            background-color: #10b981 !important;
            color: #fff !important;
            border-radius: 50px; /* Rounded pill style typical of Mobirise */
            padding: 12px 30px;
            font-weight: 700;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-omni-success:hover {
            background-color: #059669 !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        }
        .btn-omni-primary {
            background-color: #1e3a8a !important;
            color: #fff !important;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 700;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-omni-primary:hover {
            background-color: #1e40af !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 58, 138, 0.2);
        }
        .card-mobirise {
            border: none !important;
            border-radius: 24px !important; /* Premium rounded-5 look */
            box-shadow: 0 10px 30px rgba(0,0,0,0.04) !important;
            background: #ffffff;
            padding: 2.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-mobirise:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.08) !important;
        }
        /* Custom spacing and typography */
        .text-omni-primary { color: #1e3a8a !important; }
        .text-omni-success { color: #10b981 !important; }
        .bg-omni-light { background-color: #f8fafc !important; }
        .fw-extrabold { font-weight: 800 !important; }
        .rounded-mobirise { border-radius: 24px !important; }
    </style>
</head>
<body>

    <!-- Default Mobirise-style Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm sticky-top">
      <div class="container">
        <a class="navbar-brand fw-extrabold fs-4" href="{{ url('/') }}">
            <i class="bi bi-shield-fill-check text-omni-success me-2"></i>Omni<span class="text-omni-success">Civic</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold">
            <li class="nav-item">
              <a class="nav-link px-3" href="{{ url('/') }}#fitur">Fitur Utama</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="{{ url('/') }}#alur">Alur Otorisasi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link px-3" href="{{ route('presentation') }}"><i class="bi bi-projector-fill text-omni-success me-1"></i>Presentasi</a>
            </li>
          </ul>
          <div class="d-flex gap-2">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-omni-primary">Ke Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-link text-decoration-none text-dark fw-bold">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-omni-primary">Mulai Simulasi</a>
            @endauth
          </div>
        </div>
      </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Mobirise-style Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container text-center text-md-start">
            <div class="row gy-4 align-items-center">
                <div class="col-md-6">
                    <h5 class="fw-extrabold mb-1"><i class="bi bi-shield-fill-check text-omni-success me-2"></i>OmniCivic</h5>
                    <p class="text-secondary small mb-0">&copy; 2026 OmniCivic. Hak Cipta Dilindungi Undang-Undang.</p>
                </div>
                <div class="col-md-6 text-md-end text-secondary small">
                    <p class="mb-1">Dikembangkan oleh <span class="fw-bold text-light">Kurniawan</span></p>
                    <p class="mb-0">Pernyataan Kepatuhan: Platform OmniCivic mematuhi regulasi keuangan Parpol (ISAK 35).</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
