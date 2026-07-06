@extends('layouts.public')

@section('title', 'PT Multi Power Abadi - Konstruksi Baja, Gudang & Bangunan Industri')

@section('content')
<!-- Hero Section -->
<section id="home" class="hero-section overflow-hidden position-relative d-flex align-items-center justify-content-center" style="min-height: 85vh; padding-top: 60px; padding-bottom: 70px;">
    <!-- Animated Moving Background Slider (4 Real Project Photos) -->
    <div class="hero-bg-slider position-absolute top-0 start-0 w-100 h-100" style="z-index: 1;">
        <div class="hero-slide active" style="background-image: url('{{ asset('images/hero-1.jpg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/hero-2.jpg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/hero-3.jpg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/hero-4.png') }}');"></div>
    </div>
    <!-- Gradient Overlay for Contrast -->
    <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index: 2; background: linear-gradient(135deg, rgba(11, 19, 41, 0.88) 0%, rgba(15, 23, 42, 0.78) 50%, rgba(13, 0, 0, 0.85) 100%);"></div>
    <!-- Animated moving red light glow -->
    <div class="hero-red-light"></div>
    <!-- Dust particles canvas -->
    <canvas id="hero-particles"></canvas>
    <!-- Red diagonal accent -->
    <div class="position-absolute" style="z-index: 3; top: 0; right: 0; width: 40%; height: 100%; background: linear-gradient(135deg, transparent 40%, rgba(220, 38, 38, 0.12) 100%); clip-path: polygon(30% 0, 100% 0, 100% 100%, 0% 100%);"></div>
    <div class="position-absolute" style="z-index: 3; top: 0; right: -5%; width: 25%; height: 100%; background: rgba(180, 10, 10, 0.55); clip-path: polygon(60% 0, 100% 0, 100% 100%, 30% 100%);"></div>
    <div class="container hero-content text-center position-relative" style="z-index: 5; margin-top: -25px;">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9 text-center">
                <h1 class="hero-title display-4 text-white fw-bold mb-3" style="letter-spacing: -1px;">
                    Konstruksi Baja Profesional<br class="d-none d-md-block">
                    untuk Gudang, Pabrik, dan Infrastruktur Industri
                </h1>
                <p class="hero-subtitle lead text-white-50 mb-4 mx-auto" style="max-width: 720px;">
                    PT. Multi Power Abadi menghadirkan layanan konstruksi baja premium, fabrikasi presisi, dan steel erection untuk proyek industri yang menuntut kekuatan, keamanan, dan penyerahan tepat waktu.
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3 reveal" style="transition-delay: 0.5s;">
                    <a href="{{ route('public.quotation') }}" class="btn btn-accent btn-lg btn-ripple shadow-lg px-4 text-white" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">Request Quotation</a>
                    <a href="{{ route('public.projects.index') }}" class="btn btn-outline-white btn-lg btn-ripple px-4">Lihat Portfolio</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Scroll Down Indicator -->
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 text-center reveal" style="z-index: 7; transition-delay: 0.8s;">
        <a href="#stats" class="text-white text-decoration-none">
            <div class="d-flex flex-column align-items-center">
                <span class="text-white-50 text-uppercase small mb-2" style="letter-spacing: 2px;">Scroll Down</span>
                <i class="bi bi-chevron-down fs-4 animate-bounce"></i>
            </div>
        </a>
    </div>
</section>

<!-- Statistics Grid — Premium Dark -->
<section id="stats" class="stats-premium py-5">
    <div class="container py-3">
        <div class="row g-0">
            <div class="col-6 col-md-3 reveal" style="transition-delay:0.1s;">
                <div class="stat-premium-card">
                    <div class="stat-premium-icon"><i class="bi bi-calendar-check"></i></div>
                    <div class="stat-premium-number stat-number" data-target="{{ $stats['years_experience'] ?? '15' }}" data-suffix="+">0</div>
                    <div class="stat-premium-label">Tahun Pengalaman</div>
                </div>
            </div>
            <div class="col-6 col-md-3 reveal" style="transition-delay:0.2s;">
                <div class="stat-premium-card">
                    <div class="stat-premium-icon"><i class="bi bi-building-check"></i></div>
                    <div class="stat-premium-number stat-number" data-target="{{ $stats['projects_completed'] ?? '150' }}" data-suffix="+">0</div>
                    <div class="stat-premium-label">Proyek Selesai</div>
                </div>
            </div>
            <div class="col-6 col-md-3 reveal" style="transition-delay:0.3s;">
                <div class="stat-premium-card">
                    <div class="stat-premium-icon"><i class="bi bi-people-fill"></i></div>
                    <div class="stat-premium-number stat-number" data-target="{{ $stats['experts_count'] ?? '50' }}" data-suffix="+">0</div>
                    <div class="stat-premium-label">Tenaga Ahli</div>
                </div>
            </div>
            <div class="col-6 col-md-3 reveal" style="transition-delay:0.4s;">
                <div class="stat-premium-card">
                    <div class="stat-premium-icon"><i class="bi bi-shield-fill-check"></i></div>
                    <div class="stat-premium-number">{{ $stats['work_accidents'] ?? '0' }}</div>
                    <div class="stat-premium-label">Kecelakaan Kerja</div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- About / Intro Section -->
<section id="about" class="py-5 bg-light">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 reveal reveal-left">
                <div class="position-relative overflow-hidden rounded-4 shadow-lg" style="min-height: 350px; background: linear-gradient(135deg, #0b1329 0%, #1e293b 100%);">
                    <!-- Industrial Steel Construction SVG Graphic -->
                    <svg width="100%" height="350" viewBox="0 0 600 350" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="aboutGrid" width="30" height="30" patternUnits="userSpaceOnUse">
                                <path d="M 30 0 L 0 0 0 30" fill="none" stroke="rgba(255,255,255,0.04)" stroke-width="1"/>
                            </pattern>
                            <linearGradient id="beamGrad" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#dc2626"/>
                                <stop offset="100%" stop-color="#991b1b"/>
                            </linearGradient>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#aboutGrid)"/>
                        <!-- Diagonal Construction Beams -->
                        <path d="M 40 320 L 200 70 L 360 320 M 200 70 L 560 320" stroke="url(#beamGrad)" stroke-width="10" stroke-linecap="round"/>
                        <path d="M 90 240 H 480 M 140 160 H 330" stroke="rgba(255,255,255,0.18)" stroke-width="6"/>
                        <!-- Structural Pillars & Crane Wire -->
                        <path d="M 40 320 V 140 M 200 320 V 70 M 360 320 V 140 M 560 320 V 140" stroke="#0284c7" stroke-width="6" opacity="0.7"/>
                        <path d="M 200 70 L 460 30 M 460 30 V 190" stroke="#eab308" stroke-width="5" stroke-dasharray="8 6"/>
                        <circle cx="460" cy="190" r="12" fill="#eab308"/>
                    </svg>
                    <!-- Floating Badge -->
                    <div class="position-absolute bottom-0 start-0 bg-danger text-white p-4 rounded-4 m-3 shadow-lg float-effect">
                        <h4 class="fw-bold mb-0">{{ $stats['years_experience'] ?? '15' }}+ Tahun</h4>
                        <p class="mb-0 text-sm">Menghadirkan Struktur Baja Andalan</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reveal reveal-right" style="transition-delay: 0.2s;">
                <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px;">Layanan Konstruksi Baja</span>
                <h2 class="mt-2 mb-4 display-6 fw-bold text-navy">Solusi Struktur Baja Terintegrasi Untuk Industri</h2>
                <p class="text-muted mb-4 lead">PT. Multi Power Abadi melayani proyek konstruksi baja untuk gudang, pabrik, hangar, dan bangunan industri dengan pendekatan teknis yang matang dan eksekusi lapangan terkontrol.</p>
                <p class="text-muted mb-4">Kami menggabungkan desain struktural, fabrikasi workshop, serta steel erection lapangan menjadi satu layanan end-to-end yang menjamin kualitas, kekuatan, dan ketahanan jangka panjang.</p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-danger fs-5"></i>
                            <span class="fw-semibold text-navy">Desain Struktur Baja</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-danger fs-5"></i>
                            <span class="fw-semibold text-navy">Fabrikasi & Erection</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Services Section -->
<section id="services" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-warning" style="letter-spacing: 2px;">Layanan Kami</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Solusi Konstruksi Baja End-to-End</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Layanan struktur baja lengkap dari desain, fabrikasi, steel erection, hingga serah terima untuk gudang dan fasilitas industri.</p>
        </div>

        <div class="row g-4">
            @forelse($services as $index => $service)
                <div class="col-md-6 col-lg-4 reveal" style="transition-delay: {{ 0.1 * ($index + 1) }}s;">
                    <div class="service-card h-100 border rounded-4 shadow-sm overflow-hidden bg-white">
                        <div class="card-img-wrapper" style="height: 220px; overflow: hidden; position: relative;">
                            <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://images.unsplash.com/photo-1581094288338-2314dddb7ecc?q=80&w=600&auto=format&fit=crop' }}" class="w-100 h-100 object-fit-cover transition-zoom" alt="{{ $service->title }}">
                        </div>
                        <div class="card-body p-4 position-relative d-flex flex-column justify-content-between">
                            <div>
                                <div class="service-icon-box mb-3">
                                    <i class="bi {{ $service->icon ?? 'bi-building' }}"></i>
                                </div>
                                <h4 class="card-title fw-bold text-navy mb-2">{{ $service->title }}</h4>
                                <p class="text-muted mb-3">{{ Str::limit($service->description, 110) }}</p>
                            </div>
                            <div class="mt-2">
                                <a href="{{ route('public.services.detail', $service->slug) }}" class="btn-service-more">
                                    <span>Selengkapnya</span> <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback static services if DB is empty -->
                @php
                    $staticServices = [
                        ['title' => 'Konstruksi Gudang', 'desc' => 'Desain & pembangunan gudang skala kecil hingga logistik enterprise dengan bentang lebar tanpa tiang tengah.', 'icon' => 'bi-building-fill-add', 'img' => asset('images/gudang-pabrik.jpg')],
                        ['title' => 'Konstruksi Baja', 'desc' => 'Struktur baja berat untuk pabrik, gedung bertingkat, hangar pesawat, dengan kestabilan seismik optimal.', 'icon' => 'bi-cone-striped', 'img' => asset('images/konstruksi-baja.jpg')],
                        ['title' => 'Fabrikasi Baja', 'desc' => 'Pemotongan, pembentukan, pengeboran, dan pengelasan plat & profil baja di workshop tersertifikasi milik kami.', 'icon' => 'bi-tools', 'img' => asset('images/fabrikasi-baja.jpg')],
                        ['title' => 'Steel Erection', 'desc' => 'Pemasangan komponen struktur baja di lapangan secara cepat, akurat, aman dengan tim crane bersertifikat.', 'icon' => 'bi-wrench-adjustable', 'img' => asset('images/steel-erection.jpg')],
                        ['title' => 'Bangunan Industri', 'desc' => 'Pembangunan pabrik kimia, pengolahan makanan, workshop industri lengkap dengan utilitas kelistrikan & ducting.', 'icon' => 'bi-industry', 'img' => asset('images/bangunan-industri.jpg')]
                    ];
                @endphp
                @foreach($staticServices as $index => $item)
                    <div class="col-md-6 col-lg-4 reveal" style="transition-delay: {{ 0.1 * ($index + 1) }}s;">
                        <div class="service-card h-100 border rounded-4 shadow-sm overflow-hidden bg-white">
                            <div class="card-img-wrapper" style="height: 220px; overflow: hidden; position: relative;">
                                <img src="{{ $item['img'] }}" class="w-100 h-100 object-fit-cover" alt="{{ $item['title'] }}">
                            </div>
                            <div class="card-body p-4 position-relative d-flex flex-column justify-content-between">
                                <div>
                                    <div class="service-icon-box mb-3">
                                        <i class="bi {{ $item['icon'] }}"></i>
                                    </div>
                                    <h4 class="card-title fw-bold text-navy mb-2">{{ $item['title'] }}</h4>
                                    <p class="text-muted mb-3">{{ $item['desc'] }}</p>
                                </div>
                                <div class="mt-2">
                                    <a href="{{ route('public.services.index') }}" class="btn-service-more">
                                        <span>Selengkapnya</span> <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<!-- Layanan Lainnya Section -->
<section id="other-services" class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">LAYANAN DUKUNGAN</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Layanan Lainnya</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 720px; font-size: 0.95rem;">Selain sebagai kontraktor baja, PT. Multi Power Abadi juga menyediakan berbagai layanan konstruksi dan interior untuk memenuhi kebutuhan proyek residensial maupun komersial.</p>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-2">
            @forelse($otherServices as $index => $service)
                @php
                    $isObj = is_object($service);
                    $title = $isObj ? $service->title : ($service['title'] ?? '');
                    $desc = $isObj ? $service->description : ($service['desc'] ?? $service['description'] ?? '');
                    $icon = $isObj ? $service->icon : ($service['icon'] ?? 'bi-tools');
                @endphp
                <div class="col reveal" style="transition-delay: {{ 0.1 * ($index + 1) }}s;">
                    <div class="other-service-card h-100 p-4 bg-white rounded-4 border shadow-sm transition-all position-relative overflow-hidden d-flex flex-column">
                        <div class="other-service-icon-box mb-4 d-inline-flex align-items-center justify-content-center rounded-3">
                            <i class="bi {{ $icon }}"></i>
                        </div>
                        <h5 class="fw-bold text-navy mb-3 fs-6" style="line-height: 1.4;">{{ $title }}</h5>
                        <p class="text-muted text-sm mb-0 flex-grow-1" style="font-size: 0.88rem; line-height: 1.6;">{{ $desc }}</p>
                    </div>
                </div>
            @empty
                @php
                    $staticOtherServices = [
                        ['title' => 'Konstruksi Renovasi Residensial & Komersial', 'desc' => 'Melayani renovasi rumah, gedung perkantoran, ruko, toko, restoran, dan bangunan komersial dengan hasil yang berkualitas dan sesuai kebutuhan klien.', 'icon' => 'bi-house-gear-fill'],
                        ['title' => 'Design Build Arsitektur & Interior', 'desc' => 'Menyediakan layanan desain arsitektur, desain interior, hingga pembangunan secara menyeluruh dalam satu proses yang terintegrasi.', 'icon' => 'bi-vector-pen'],
                        ['title' => 'Pekerjaan Sipil, Mekanikal, Elektrikal & Plumbing (CMEP)', 'desc' => 'Menangani pekerjaan sipil, instalasi mekanikal, elektrikal, plumbing, serta sistem pendukung bangunan sesuai standar konstruksi.', 'icon' => 'bi-lightning-charge-fill'],
                        ['title' => 'Workshop Furniture & Custom Interior', 'desc' => 'Memproduksi berbagai furniture custom, kitchen set, office furniture, partisi, serta kebutuhan interior sesuai desain dan spesifikasi proyek.', 'icon' => 'bi-hammer']
                    ];
                @endphp
                @foreach($staticOtherServices as $index => $service)
                    <div class="col reveal" style="transition-delay: {{ 0.15 * ($index + 1) }}s;">
                        <div class="other-service-card h-100 p-4 bg-white rounded-4 border shadow-sm transition-all position-relative overflow-hidden d-flex flex-column">
                            <div class="other-service-icon-box mb-4 d-inline-flex align-items-center justify-content-center rounded-3">
                                <i class="bi {{ $service['icon'] }}"></i>
                            </div>
                            <h5 class="fw-bold text-navy mb-3 fs-6" style="line-height: 1.4;">{{ $service['title'] }}</h5>
                            <p class="text-muted text-sm mb-0 flex-grow-1" style="font-size: 0.88rem; line-height: 1.6;">{{ $service['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-warning" style="letter-spacing: 2px;">Kelebihan Kami</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Mengapa PT Multi Power Abadi?</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Kami memberikan jaminan standar konstruksi tertinggi untuk menjamin investasi industri Anda terlindungi.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.1s;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card">
                    <i class="bi bi-patch-check-fill text-warning fs-2 mb-3 d-block"></i>
                    <h4 class="fw-bold text-navy mb-2">Sangat Berpengalaman</h4>
                    <p class="text-muted mb-0">Telah dipercaya menyelesaikan ratusan hangar, pabrik, gudang logistik bentang lebar, dan tangki baja.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.2s;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card">
                    <i class="bi bi-people-fill text-warning fs-2 mb-3 d-block"></i>
                    <h4 class="fw-bold text-navy mb-2">Tim Profesional</h4>
                    <p class="text-muted mb-0">Memiliki arsitek struktur baja & pengawas proyek berpengalaman bersertifikasi keahlian K3 Konstruksi.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.3s;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card">
                    <i class="bi bi-layers-fill text-warning fs-2 mb-3 d-block"></i>
                    <h4 class="fw-bold text-navy mb-2">Material Berkualitas</h4>
                    <p class="text-muted mb-0">Hanya menggunakan baja canai panas, wf, H-Beam berstandar sertifikasi uji tarik SNI resmi.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.4s;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card">
                    <i class="bi bi-alarm-fill text-warning fs-2 mb-3 d-block"></i>
                    <h4 class="fw-bold text-navy mb-2">Tepat Waktu</h4>
                    <p class="text-muted mb-0">Manajemen rantai pasok fabrikasi mandiri membuat proyek berjalan efisien bebas hambatan.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.5s;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card">
                    <i class="bi bi-shield-fill-exclamation text-warning fs-2 mb-3 d-block"></i>
                    <h4 class="fw-bold text-navy mb-2">Keselamatan Kerja (K3)</h4>
                    <p class="text-muted mb-0">Penerapan standar operasional ketat untuk mewujudkan Zero Accident di seluruh area kerja.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.6s;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card">
                    <i class="bi bi-award-fill text-warning fs-2 mb-3 d-block"></i>
                    <h4 class="fw-bold text-navy mb-2">Garansi Kualitas</h4>
                    <p class="text-muted mb-0">Memberikan jaminan masa pemeliharaan pasca serah terima untuk memastikan struktur baja sempurna.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Process Section -->
<section id="process" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-warning" style="letter-spacing: 2px;">Tahapan Kerja</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Proses Pengerjaan Sistematis</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Kami mengikuti alur kerja transparan untuk memastikan kepuasan klien dari awal hingga akhir.</p>
        </div>

        <div class="process-timeline reveal">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="process-step-item">
                        <div class="process-icon-wrapper">1</div>
                        <h5 class="process-step-title">Konsultasi</h5>
                        <p class="process-step-desc">Mendiskusikan kebutuhan struktur gudang, bentang, tinggi, dan kebutuhan utilitas klien.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="process-step-item">
                        <div class="process-icon-wrapper">2</div>
                        <h5 class="process-step-title">Survey Lokasi</h5>
                        <p class="process-step-desc">Melakukan survey topografi tanah, struktur tanah, dan akses jalan crane proyek.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="process-step-item">
                        <div class="process-icon-wrapper">3</div>
                        <h5 class="process-step-title">Perencanaan & Estimasi</h5>
                        <p class="process-step-desc">Membuat visualisasi desain 3D, kalkulasi kekuatan pembebanan (SAP2000), dan Rencana Anggaran Biaya.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="process-step-item">
                        <div class="process-icon-wrapper">4</div>
                        <h5 class="process-step-title">Fabrikasi & Instalasi</h5>
                        <p class="process-step-desc">Melakukan pemotongan plat baja di workshop lalu melakukan pengiriman dan steel erection di lokasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Project Showcase Section -->
<section id="projects" class="py-5 bg-light">
    <div class="container py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-5 reveal">
            <div>
                <span class="text-uppercase fw-bold text-warning" style="letter-spacing: 2px;">Portfolio</span>
                <h2 class="mt-2 display-6 fw-bold text-navy">Dokumentasi Proyek</h2>
            </div>
            <!-- Dynamic project filter buttons -->
            <div class="filter-btn-group d-flex gap-2 mt-3 mt-lg-0">
                <button type="button" class="btn filter-btn active" data-filter="all">Semua</button>
                <button type="button" class="btn filter-btn" data-filter="Gudang">Gudang</button>
                <button type="button" class="btn filter-btn" data-filter="Baja">Konstruksi Baja</button>
                <button type="button" class="btn filter-btn" data-filter="Industri">Industri</button>
            </div>
        </div>

        <div class="row g-4">
            @forelse($projects as $project)
                <div class="col-md-6 col-lg-4 project-showcase-item reveal" data-category="{{ $project->category }}">
                    <div class="project-card border rounded-4 overflow-hidden position-relative shadow-sm" style="height: 290px;">
                        <img src="{{ $project->image ? asset('storage/' . $project->image) : asset('images/gudang-pabrik.jpg') }}" class="w-100 h-100 object-fit-cover transition-zoom" alt="{{ $project->title }}">
                        <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy">
                            <span class="project-card-category badge bg-danger text-white fw-semibold text-uppercase text-xs mb-2 align-self-start shadow-sm" style="letter-spacing: 0.8px;">{{ $project->category }}</span>
                            <h4 class="project-card-title text-white fw-bold my-1" style="font-size: 1.2rem;">{{ $project->title }}</h4>
                            <div class="project-card-location text-white-50 small">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $project->location }}, {{ $project->year }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback static projects if DB is empty -->
                @php
                    $staticProjects = [
                        [
                            'title' => 'Gudang Logistik Modern',
                            'category' => 'Gudang',
                            'location' => 'Bekasi, Jawa Barat',
                            'year' => 2025,
                            'image' => asset('images/gudang-pabrik.jpg')
                        ],
                        [
                            'title' => 'Hangar Pemeliharaan Pesawat',
                            'category' => 'Konstruksi Baja',
                            'location' => 'Tangerang, Banten',
                            'year' => 2024,
                            'image' => asset('images/steel-erection.jpg')
                        ],
                        [
                            'title' => 'Pabrik Pengolahan Sawit',
                            'category' => 'Bangunan Industri',
                            'location' => 'Pekanbaru, Riau',
                            'year' => 2023,
                            'image' => asset('images/bangunan-industri.jpg')
                        ]
                    ];
                @endphp
                @foreach($staticProjects as $item)
                    <div class="col-md-6 col-lg-4 project-showcase-item reveal" data-category="{{ $item['category'] }}">
                        <div class="project-card border rounded-4 overflow-hidden position-relative shadow-sm" style="height: 280px;">
                            <img src="{{ $item['image'] }}" class="w-100 h-100 object-fit-cover transition-zoom" alt="{{ $item['title'] }}">
                            <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy">
                                <span class="project-card-category badge bg-danger text-white fw-semibold text-uppercase text-xs mb-2 align-self-start shadow-sm" style="letter-spacing: 0.8px;">{{ $item['category'] }}</span>
                                <h4 class="project-card-title text-white fw-bold my-1" style="font-size: 1.2rem;">{{ $item['title'] }}</h4>
                                <div class="project-card-location text-white-50 small">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $item['location'] }}, {{ $item['year'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<!-- Clients Section -->
<section id="clients" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">MITRA KAMI</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Klien Kami</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 700px; font-size: 0.95rem;">Kami menjalin kemitraan erat dengan berbagai pengembang properti komersial, penyedia logistik, dan manufaktur berskala nasional.</p>
        </div>

        @php
            $ourClients = [
                ['name' => 'KSB', 'sub' => 'Pumps & Valves', 'color' => '#00529c', 'icon' => 'bi-gear-wide-connected', 'logo' => asset('images/client-ksb.png')],
                ['name' => 'Surya Pertiwi', 'sub' => 'Sanitary & Building', 'color' => '#dc2626', 'icon' => 'bi-brightness-high-fill', 'logo' => asset('images/client-surya-pertiwi.png')],
                ['name' => 'Telkomsel', 'sub' => 'Telecommunication', 'color' => '#ed1d24', 'icon' => 'bi-reception-4', 'logo' => asset('images/client-telkomsel.png')],
                ['name' => 'ABB', 'sub' => 'Power & Automation', 'color' => '#e11d48', 'icon' => 'bi-lightning-charge-fill', 'logo' => asset('images/client-abb.png')],
                ['name' => 'BNN', 'sub' => 'Republik Indonesia', 'color' => '#1e3a8a', 'icon' => 'bi-shield-shaded', 'logo' => asset('images/client-bnn.png')],
                ['name' => 'Kimia Farma', 'sub' => 'Healthcare & Pharma', 'color' => '#0284c7', 'icon' => 'bi-capsule', 'logo' => asset('images/client-kimia-farma.png')],
                ['name' => 'Telkom Landmark', 'sub' => 'Tower & Property', 'color' => '#dc2626', 'icon' => 'bi-building', 'logo' => asset('images/client-telkom-landmark.png')],
                ['name' => 'UNAIR', 'sub' => 'Airlangga University', 'color' => '#d97706', 'icon' => 'bi-mortarboard-fill', 'logo' => asset('images/client-unair.jpg')],
                ['name' => 'Mandiri Taspen', 'sub' => 'Bank Financial', 'color' => '#1e40af', 'icon' => 'bi-bank2', 'logo' => asset('images/client-mandiri-taspen.png')],
                ['name' => 'KB Bukopin', 'sub' => 'Financial Group', 'color' => '#ca8a04', 'icon' => 'bi-wallet2', 'logo' => asset('images/client-kb-bukopin.png')],
                ['name' => 'TOTO', 'sub' => 'Japan Quality', 'color' => '#0f172a', 'icon' => 'bi-droplet-fill', 'logo' => asset('images/client-toto.png')],
                ['name' => 'Indonesia Sehat', 'sub' => 'Medical Center', 'color' => '#16a34a', 'icon' => 'bi-heart-pulse-fill', 'logo' => asset('images/client-indonesia-sehat.png')],
                ['name' => 'ITS', 'sub' => 'Sepuluh Nopember', 'color' => '#0284c7', 'icon' => 'bi-diagram-3-fill', 'logo' => asset('images/client-its.png')],
                ['name' => 'BKI', 'sub' => 'Classification Soc.', 'color' => '#0369a1', 'icon' => 'bi-anchor', 'logo' => asset('images/client-bki.png')],
                ['name' => 'Angkasa Pura', 'sub' => 'Logistics Services', 'color' => '#0284c7', 'icon' => 'bi-airplane-engines-fill', 'logo' => asset('images/client-angkasa-pura.png')],
                ['name' => 'Piranti', 'sub' => 'Engineering', 'color' => '#dc2626', 'icon' => 'bi-tools', 'logo' => asset('images/client-piranti.png')],
                ['name' => 'Tiket.com', 'sub' => 'Travel & Ticketing', 'color' => '#1d6fe8', 'icon' => 'bi-airplane-fill', 'logo' => asset('images/client-tiket.png')],
                ['name' => 'Mitra', 'sub' => 'Partner', 'color' => '#1e3a8a', 'icon' => 'bi-building', 'logo' => asset('images/client-new18.png')],
                ['name' => 'Grounded Event', 'sub' => 'Coach Dr. Fahmi', 'color' => '#d4a800', 'icon' => 'bi-trophy-fill', 'logo' => asset('images/client-grounded-event.png')]
            ];
        @endphp

        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-4 justify-content-center">
            @foreach($ourClients as $index => $client)
                @php
                    $delay = ($index % 8) * 0.05;
                @endphp
                <div class="col reveal" style="transition-delay: {{ $delay }}s;">
                    <div class="client-brand-card">
                        <div class="client-card-inner w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3 text-center">
                            @if(!empty($client['logo']))
                                <img src="{{ $client['logo'] }}" alt="{{ $client['name'] }}" class="img-fluid client-logo-img">
                            @else
                                <div class="d-flex align-items-center justify-content-center rounded-3 mb-2 shadow-sm" style="width: 48px; height: 48px; background: {{ $client['color'] }}12; color: {{ $client['color'] }}; font-size: 1.4rem;">
                                    <i class="bi {{ $client['icon'] }}"></i>
                                </div>
                                <span class="fw-bold text-navy" style="font-size: 0.95rem; letter-spacing: -0.2px; line-height: 1.2;">{{ $client['name'] }}</span>
                                <span class="text-muted fw-semibold mt-1" style="font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.5px;">{{ $client['sub'] }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section py-5 overflow-hidden position-relative">
    <div class="position-absolute top-0 start-0 w-100 h-100 hero-zoom-bg" style="background-image: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
    <div class="cta-overlay position-absolute top-0 start-0 w-100 h-100" style="background: rgba(15, 45, 92, 0.9); z-index: 2;"></div>
    <div class="container py-5 text-center reveal" style="z-index: 3; position: relative;">
        <h2 class="display-5 text-white fw-bold mb-3">Siap Mewujudkan Proyek Konstruksi Baja Anda?</h2>
        <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 650px;">Hubungi tim kami untuk solusi struktur baja yang kuat, efisien, dan siap diproduksi dengan standar konstruksi industri terbaik.</p>
        <a href="{{ route('public.quotation') }}" class="btn btn-warning btn-lg btn-ripple text-navy fw-semibold px-4 shadow">Mulai Request Quotation</a>
    </div>
</section>

@endsection
