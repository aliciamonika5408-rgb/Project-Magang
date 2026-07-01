@extends('layouts.public')

@section('title', 'PT Multi Power Abadi - Konstruksi Baja, Gudang & Bangunan Industri')

@section('content')
<!-- Hero Section -->
<section id="home" class="hero-section overflow-hidden position-relative" style="min-height: 95vh; margin-top: -80px;">
    <div class="position-absolute top-0 start-0 w-100 h-100 hero-zoom-bg" style="background-image: url('https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
    <div class="hero-overlay" style="z-index: 2; background: linear-gradient(135deg, rgba(30, 30, 30, 0.88) 0%, rgba(30, 30, 30, 0.75) 100%);"></div>
    <!-- Red diagonal accent -->
    <div class="position-absolute" style="z-index: 2; top: 0; right: 0; width: 40%; height: 100%; background: linear-gradient(135deg, transparent 40%, rgba(220, 38, 38, 0.15) 100%); clip-path: polygon(30% 0, 100% 0, 100% 100%, 0% 100%);"></div>
    <div class="position-absolute" style="z-index: 2; top: 0; right: -5%; width: 25%; height: 100%; background: rgba(220, 38, 38, 0.6); clip-path: polygon(60% 0, 100% 0, 100% 100%, 30% 100%);"></div>
    <div class="container hero-content text-center text-lg-start" style="z-index: 3; position: relative; padding-top: 100px;">
        <div class="row align-items-center g-5">
            <div class="col-lg-8">
                <h1 class="hero-title reveal display-4 text-white fw-bold mb-3" style="letter-spacing: -1px; transition-delay: 0.1s;">
                    Membangun Struktur,<br>
                    <span style="color: var(--accent-orange);">Menguatkan</span> Masa Depan
                </h1>
                <p class="hero-subtitle reveal lead text-white-50 mb-4" style="transition-delay: 0.3s; max-width: 650px;">
                    Layanan konstruksi baja, fabrikasi, dan steel erection berkualitas dengan standar keamanan terbaik.
                </p>
                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 reveal" style="transition-delay: 0.5s;">
                    <a href="{{ route('public.quotation') }}" class="btn btn-accent btn-lg btn-ripple shadow-lg px-4 text-white">Request Quotation</a>
                    <a href="{{ route('public.projects.index') }}" class="btn btn-outline-white btn-lg btn-ripple px-4">Lihat Portfolio</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Scroll Down Indicator -->
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 text-center reveal" style="z-index: 3; transition-delay: 0.8s;">
        <a href="#stats" class="text-white text-decoration-none">
            <div class="d-flex flex-column align-items-center">
                <span class="text-white-50 text-uppercase small mb-2" style="letter-spacing: 2px;">Scroll Down</span>
                <i class="bi bi-chevron-down fs-4 animate-bounce"></i>
            </div>
        </a>
    </div>
</section>

<!-- Statistics Grid -->
<section id="stats" class="py-5 bg-white border-bottom">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-6 col-md-3 reveal" style="transition-delay: 0.1s;">
                <div class="stat-item p-4 border rounded-4 h-100" style="border-color: #e5e7eb !important;">
                    <div class="mb-2"><i class="bi bi-calendar-check fs-3" style="color: var(--accent-orange);"></i></div>
                    <div class="stat-number display-5 fw-bold" style="color: var(--text-dark);" data-target="10" data-suffix="+">0</div>
                    <div class="stat-label text-muted small text-uppercase" style="letter-spacing: 1px;">Tahun<br>Pengalaman</div>
                </div>
            </div>
            <div class="col-6 col-md-3 reveal" style="transition-delay: 0.2s;">
                <div class="stat-item p-4 border rounded-4 h-100" style="border-color: #e5e7eb !important;">
                    <div class="mb-2"><i class="bi bi-building-check fs-3" style="color: var(--accent-orange);"></i></div>
                    <div class="stat-number display-5 fw-bold" style="color: var(--text-dark);" data-target="150" data-suffix="+">0</div>
                    <div class="stat-label text-muted small text-uppercase" style="letter-spacing: 1px;">Proyek<br>Selesai</div>
                </div>
            </div>
            <div class="col-6 col-md-3 reveal" style="transition-delay: 0.3s;">
                <div class="stat-item p-4 border rounded-4 h-100" style="border-color: #e5e7eb !important;">
                    <div class="mb-2"><i class="bi bi-patch-check fs-3" style="color: var(--accent-orange);"></i></div>
                    <div class="stat-number display-5 fw-bold" style="color: var(--text-dark);" data-target="100" data-suffix="%">0</div>
                    <div class="stat-label text-muted small text-uppercase" style="letter-spacing: 1px;">Komitmen<br>Kualitas</div>
                </div>
            </div>
            <div class="col-6 col-md-3 reveal" style="transition-delay: 0.4s;">
                <div class="stat-item p-4 border rounded-4 h-100" style="border-color: #e5e7eb !important;">
                    <div class="mb-2"><i class="bi bi-shield-check fs-3" style="color: var(--accent-orange);"></i></div>
                    <div class="stat-number display-5 fw-bold" style="color: var(--text-dark);" data-target="0" data-suffix="">0</div>
                    <div class="stat-label text-muted small text-uppercase" style="letter-spacing: 1px;">Kecelakaan<br>Kerja</div>
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
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=800&auto=format&fit=crop" class="img-fluid rounded-4 shadow-lg" alt="Construction Site">
                    <div class="position-absolute bottom-0 start-0 bg-warning text-dark p-4 rounded-4 m-3 shadow-lg float-effect">
                        <h4 class="fw-bold mb-0">15+ Tahun</h4>
                        <p class="mb-0 text-sm">Menangani Proyek Konstruksi Baja Besar</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reveal reveal-right" style="transition-delay: 0.2s;">
                <span class="text-uppercase fw-bold text-warning" style="letter-spacing: 2px;">Tentang Kami</span>
                <h2 class="mt-2 mb-4 display-6 fw-bold text-navy">Membangun Masa Depan Dengan Konstruksi Baja Kokoh</h2>
                <p class="text-muted mb-4 lead">PT. Multi Power Abadi adalah spesialis dalam pembangunan gedung industri, pergudangan, struktur baja, fabrikasi baja berkualitas tinggi, dan pemasangan baja presisi (steel erection).</p>
                <p class="text-muted mb-4">Kami memadukan material bersertifikat, mesin modern, serta tim insinyur ahli untuk menjamin keamanan, efisiensi biaya, dan ketepatan waktu serah terima proyek.</p>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-warning fs-5"></i>
                            <span class="fw-semibold text-navy">Peralatan Modern</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-warning fs-5"></i>
                            <span class="fw-semibold text-navy">Material Bersertifikat SNI</span>
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
            <h2 class="mt-2 display-6 fw-bold text-navy">Solusi Konstruksi Terintegrasi</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">Kami melayani seluruh rangkaian proyek bangunan industri mulai perencanaan desain hingga finishing.</p>
        </div>

        <div class="row g-4">
            @forelse($services as $index => $service)
                <div class="col-md-6 col-lg-4 reveal" style="transition-delay: {{ 0.1 * ($index + 1) }}s;">
                    <div class="service-card h-100 border rounded-4 shadow-sm overflow-hidden bg-white">
                        <div class="card-img-wrapper" style="height: 220px; overflow: hidden; position: relative;">
                            <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://images.unsplash.com/photo-1581094288338-2314dddb7ecc?q=80&w=600&auto=format&fit=crop' }}" class="w-100 h-100 object-fit-cover transition-zoom" alt="{{ $service->title }}">
                        </div>
                        <div class="card-body p-4 position-relative">
                            <div class="service-icon-box bg-navy text-white rounded-3 d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 50px; height: 50px; font-size: 1.5rem;">
                                <i class="bi {{ $service->icon ?? 'bi-building' }}"></i>
                            </div>
                            <h4 class="card-title fw-bold text-navy mb-2">{{ $service->title }}</h4>
                            <p class="text-muted mb-3">{{ Str::limit($service->description, 110) }}</p>
                            <a href="{{ route('public.services.detail', $service->slug) }}" class="text-warning text-decoration-none fw-semibold">
                                Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback static services if DB is empty -->
                @php
                    $staticServices = [
                        ['title' => 'Konstruksi Gudang', 'desc' => 'Desain & pembangunan gudang skala kecil hingga logistik enterprise dengan bentang lebar tanpa tiang tengah.', 'icon' => 'bi-building-fill-add', 'img' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Konstruksi Baja', 'desc' => 'Struktur baja berat untuk pabrik, gedung bertingkat, hangar pesawat, dengan kestabilan seismik optimal.', 'icon' => 'bi-cone-striped', 'img' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Fabrikasi Baja', 'desc' => 'Pemotongan, pembentukan, pengeboran, dan pengelasan plat & profil baja di workshop tersertifikasi milik kami.', 'icon' => 'bi-tools', 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Steel Erection', 'desc' => 'Pemasangan komponen struktur baja di lapangan secara cepat, akurat, aman dengan tim crane bersertifikat.', 'icon' => 'bi-wrench-adjustable', 'img' => 'https://images.unsplash.com/photo-1581094288338-2314dddb7ecc?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Bangunan Industri', 'desc' => 'Pembangunan pabrik kimia, pengolahan makanan, workshop industri lengkap dengan utilitas kelistrikan & ducting.', 'icon' => 'bi-industry', 'img' => 'https://images.unsplash.com/photo-1516937941344-00b4e0337589?q=80&w=600&auto=format&fit=crop']
                    ];
                @endphp
                @foreach($staticServices as $index => $item)
                    <div class="col-md-6 col-lg-4 reveal" style="transition-delay: {{ 0.1 * ($index + 1) }}s;">
                        <div class="service-card h-100 border rounded-4 shadow-sm overflow-hidden bg-white">
                            <div class="card-img-wrapper" style="height: 220px; overflow: hidden; position: relative;">
                                <img src="{{ $item['img'] }}" class="w-100 h-100 object-fit-cover" alt="{{ $item['title'] }}">
                            </div>
                            <div class="card-body p-4 position-relative">
                                <div class="service-icon-box bg-navy text-white rounded-3 d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 50px; height: 50px; font-size: 1.5rem;">
                                    <i class="bi {{ $item['icon'] }}"></i>
                                </div>
                                <h4 class="card-title fw-bold text-navy mb-2">{{ $item['title'] }}</h4>
                                <p class="text-muted mb-3">{{ $item['desc'] }}</p>
                                <a href="{{ route('public.services.index') }}" class="text-warning text-decoration-none fw-semibold">
                                    Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
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
                    <div class="project-card border rounded-4 overflow-hidden position-relative shadow-sm" style="height: 280px;">
                        <img src="{{ $project->image ? asset('storage/' . $project->image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=600&auto=format&fit=crop' }}" class="w-100 h-100 object-fit-cover transition-zoom" alt="{{ $project->title }}">
                        <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy">
                            <span class="project-card-category text-warning fw-semibold text-uppercase text-sm">{{ $project->category }}</span>
                            <h4 class="project-card-title text-white fw-bold my-1">{{ $project->title }}</h4>
                            <div class="project-card-location text-white-50 text-sm mb-3">
                                <i class="bi bi-geo-alt-fill me-1"></i> {{ $project->location }}, {{ $project->year }}
                            </div>
                            <a href="{{ route('public.projects.detail', $project->slug) }}" class="btn btn-warning btn-sm align-self-start fw-semibold shadow">Detail Proyek</a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback static projects if DB is empty -->
                @php
                    $staticProjects = [
                        ['title' => 'Gudang Logistik Modern', 'category' => 'Gudang', 'location' => 'Bekasi, Jawa Barat', 'year' => 2025, 'img' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Hangar Pemeliharaan Pesawat', 'category' => 'Baja', 'location' => 'Tangerang, Banten', 'year' => 2024, 'img' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Pabrik Pengolahan Sawit', 'category' => 'Industri', 'location' => 'Pekanbaru, Riau', 'year' => 2023, 'img' => 'https://images.unsplash.com/photo-1516937941344-00b4e0337589?q=80&w=600&auto=format&fit=crop']
                    ];
                @endphp
                @foreach($staticProjects as $item)
                    <div class="col-md-6 col-lg-4 project-showcase-item reveal" data-category="{{ $item['category'] }}">
                        <div class="project-card border rounded-4 overflow-hidden position-relative shadow-sm" style="height: 280px;">
                            <img src="{{ $item['img'] }}" class="w-100 h-100 object-fit-cover" alt="{{ $item['title'] }}">
                            <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end">
                                <span class="project-card-category text-warning fw-semibold text-uppercase text-sm">{{ $item['category'] }}</span>
                                <h4 class="project-card-title text-white fw-bold my-1">{{ $item['title'] }}</h4>
                                <div class="project-card-location text-white-50 text-sm mb-3">
                                    <i class="bi bi-geo-alt-fill me-1"></i> {{ $item['location'] }}, {{ $item['year'] }}
                                </div>
                                <a href="{{ route('public.projects.index') }}" class="btn btn-warning btn-sm align-self-start fw-semibold shadow">Detail Proyek</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

<!-- Clients Carousel Section -->
<section id="clients" class="py-5 bg-white border-top border-bottom border-light">
    <div class="container py-2">
        <div class="text-center mb-4 reveal">
            <span class="text-uppercase fw-bold text-warning" style="letter-spacing: 2px;">Klien Kami</span>
        </div>
        <div class="logos-carousel-container reveal">
            <div class="logos-carousel-track">
                @forelse($clients as $client)
                    <div class="logos-carousel-item">
                        <img src="{{ asset('storage/' . $client->logo_path) }}" alt="{{ $client->name }}">
                    </div>
                @empty
                    <!-- Fallback logos -->
                    @for($i = 1; $i <= 6; $i++)
                        <div class="logos-carousel-item">
                            <h5 class="fw-bold text-muted mb-0">PARTNER {{ $i }}</h5>
                        </div>
                    @endfor
                    <!-- Repeat for endless animation track looping -->
                    @for($i = 1; $i <= 6; $i++)
                        <div class="logos-carousel-item">
                            <h5 class="fw-bold text-muted mb-0">PARTNER {{ $i }}</h5>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section py-5 overflow-hidden position-relative">
    <div class="position-absolute top-0 start-0 w-100 h-100 hero-zoom-bg" style="background-image: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;"></div>
    <div class="cta-overlay position-absolute top-0 start-0 w-100 h-100" style="background: rgba(15, 45, 92, 0.9); z-index: 2;"></div>
    <div class="container py-5 text-center reveal" style="z-index: 3; position: relative;">
        <h2 class="display-5 text-white fw-bold mb-3">Siap Membangun Gudang dan Struktur Baja Anda?</h2>
        <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 650px;">Diskusikan kebutuhan struktur baja industrial Anda sekarang dan dapatkan estimasi rancangan anggaran biaya (RAB) gratis.</p>
        <a href="{{ route('public.quotation') }}" class="btn btn-warning btn-lg btn-ripple text-navy fw-semibold px-4 shadow">Mulai Request Quotation</a>
    </div>
</section>

@endsection
