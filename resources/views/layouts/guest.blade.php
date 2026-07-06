<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Admin - PT Multi Power Abadi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-navy text-dark" style="background: radial-gradient(circle at center, #1e0505 0%, #0d0101 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center;">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">
                
                <!-- Brand Banner -->
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="d-inline-flex flex-column align-items-center text-decoration-none">
                        <i class="bi bi-house-door-fill text-danger display-4 mb-2"></i>
                        <span class="fs-4 fw-bold text-white mt-1" style="letter-spacing: 0.5px;">PT. MULTI POWER ABADI</span>
                        <span class="text-xs text-danger text-uppercase fw-semibold" style="letter-spacing: 2.5px;">Admin Panel Management</span>
                    </a>
                </div>

                <!-- Main Card Container -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden bg-white">
                    <div class="card-body p-4 p-md-5">
                        {{ $slot }}
                    </div>
                    <div class="card-footer bg-light border-0 py-3 text-center">
                        <a href="{{ route('home') }}" class="text-decoration-none text-muted small">
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Website Utama
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
