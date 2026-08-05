@extends('layouts.public')

@section('title', 'PT Multi Power Abadi - Konstruksi Baja, Gudang & Bangunan Industri')

@section('content')
<style>
    .transition-hover-card {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .transition-hover-card:hover {
        transform: translateY(-6px) !important;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08) !important;
        border-color: rgba(255, 193, 7, 0.25) !important;
    }
</style>
<!-- Hero Section -->
<section id="home" class="hero-section overflow-hidden position-relative d-flex align-items-center justify-content-center" style="min-height: 85vh;">
    <!-- Animated Moving Background Slider (4 Real Project Photos) -->
    <div class="hero-bg-slider position-absolute top-0 start-0 w-100 h-100" style="z-index: 1;">
        <div class="hero-slide active" style="background-image: url('{{ asset('images/hero-1.jpg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/hero-2.jpg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/hero-3.jpg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('images/hero-4.png') }}');"></div>
    </div>
    <!-- Gradient Overlay for Contrast -->
    <div class="hero-overlay position-absolute top-0 start-0 w-100 h-100" style="z-index: 2; background: linear-gradient(135deg, rgba(15, 23, 42, 0.92) 0%, rgba(15, 23, 42, 0.82) 50%, rgba(13, 0, 0, 0.88) 100%);"></div>
    <!-- Animated moving red light glow -->
    <div class="hero-red-light"></div>
    <!-- Dust particles canvas -->
    <canvas id="hero-particles"></canvas>

    <div class="container hero-content text-start position-relative" style="z-index: 5; margin-top: -25px;">
        <div class="row justify-content-start">
            <div class="col-lg-10 col-xl-9 text-start">
                <span class="badge bg-danger text-white px-3 py-2 rounded-pill text-uppercase fw-semibold mb-3 d-inline-block shadow-sm" style="letter-spacing: 1.5px; font-size: 0.82rem;">
                    <i class="bi bi-shield-fill-check me-1"></i> Kontraktor Konstruksi Baja Terpercaya
                </span>
                <h1 class="hero-title display-5 text-white fw-bold mb-4" style="letter-spacing: -1px; line-height: 1.25;">
                    Konstruksi Baja Profesional<br class="d-none d-md-block">
                    Untuk Gudang, Pabrik, dan Bangunan Industri
                </h1>

                <div class="d-flex flex-wrap justify-content-start gap-3 reveal" style="transition-delay: 0.5s;">
                    <a href="{{ route('public.quotation') }}" class="btn btn-accent btn-lg btn-ripple shadow-lg px-4 text-white fw-semibold" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        <i class="bi bi-file-earmark-text-fill me-2"></i>Minta Penawaran Proyek
                    </a>
                    <a href="https://wa.me/62811272825" target="_blank" rel="noopener noreferrer" class="btn btn-outline-white btn-lg btn-ripple px-4 fw-semibold">
                        <i class="bi bi-whatsapp me-2"></i>Konsultasi Gratis
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Scroll Down Indicator -->
    <div class="position-absolute bottom-0 start-50 translate-middle-x mb-4 text-center reveal" style="z-index: 7; transition-delay: 0.8s;">
        <a href="#stats" class="text-white text-decoration-none">
            <div class="d-flex flex-column align-items-center">
                <span class="text-white-50 text-uppercase small mb-2" style="letter-spacing: 2px;">Jelajahi Solusi</span>
                <i class="bi bi-chevron-down fs-4 animate-bounce"></i>
            </div>
        </a>
    </div>
</section>

<!-- Statistics Grid — Premium Dark -->
<section id="stats" class="py-0 position-relative stat-section" style="z-index: 10; margin-top: -55px; margin-bottom: 25px;">
    <div class="container">
        <div class="stats-premium rounded-4 p-3 shadow-lg">
            <div class="row g-0">
                <div class="col-6 col-md-3 reveal" style="transition-delay:0.1s;">
                    <div class="stat-premium-card">
                        <div class="stat-premium-number stat-number" data-target="12" data-suffix="+">0</div>
                        <div class="stat-premium-label">Tahun Pengalaman</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 reveal" style="transition-delay:0.2s;">
                    <div class="stat-premium-card">
                        <div class="stat-premium-number stat-number" data-target="1250" data-suffix="+">0</div>
                        <div class="stat-premium-label">Proyek Terbangun</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 reveal" style="transition-delay:0.3s;">
                    <div class="stat-premium-card">
                        <div class="stat-premium-number stat-number" data-target="32" data-suffix="">0</div>
                        <div class="stat-premium-label">Kota di Indonesia</div>
                    </div>
                </div>
                <div class="col-6 col-md-3 reveal" style="transition-delay:0.4s;">
                    <div class="stat-premium-card">
                        <div class="stat-premium-number stat-number" data-target="100" data-suffix="%">0</div>
                        <div class="stat-premium-label">Komitmen Mutu &amp; K3</div>
                    </div>
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
                <div class="position-relative overflow-hidden rounded-4 shadow-lg h-100" style="min-height: 420px;">
                    <!-- Background Image -->
                    <img src="{{ asset('images/layanan-baja-bg.jpg') }}" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" alt="Layanan Konstruksi Baja PT Multi Power Abadi" style="z-index: 1;">
                    <!-- Subtle Dark Gradient Overlay -->
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 2; background: linear-gradient(135deg, rgba(15, 23, 42, 0.35) 0%, rgba(15, 23, 42, 0.75) 100%);"></div>
                    
                    <!-- Floating Badge -->
                    <div class="position-absolute bottom-0 start-0 bg-danger text-white p-4 rounded-4 m-3 shadow-lg float-effect" style="z-index: 3;">
                        <h4 class="fw-bold mb-0">12+ Tahun Pengalaman</h4>
                        <p class="mb-0 text-sm">Menghadirkan Struktur Baja Industri Berstandar SNI</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 reveal reveal-right" style="transition-delay: 0.2s;">
                <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">TENTANG KAMI</span>
                <h2 class="mt-2 mb-4 display-6 fw-bold text-navy">Spesialis Konstruksi Baja &amp; Bangunan Industri Terpercaya</h2>
                <p class="text-muted mb-3 lead" style="font-size: 1.05rem;">PT. Multi Power Abadi adalah perusahaan kontraktor konstruksi baja yang berfokus pada pembangunan gudang, pabrik, hanggar, dan struktur industri dengan tingkat akurasi rekayasa tinggi.</p>
                <p class="text-muted mb-4">Kami menggabungkan perencanaan rekayasa struktural yang matang, fasilitas fabrikasi workshop mandiri, serta pengawasan *steel erection* di lapangan secara disiplin. Komitmen utama kami adalah memberikan struktur bangunan yang kokoh, tepat waktu, efisien biaya, dan bergaransi penuh demi melindungi investasi jangka panjang Anda.</p>
                
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-white border shadow-sm">
                            <i class="bi bi-shield-check text-danger fs-4"></i>
                            <div>
                                <h6 class="fw-bold text-navy mb-0" style="font-size: 0.9rem;">Material Standar SNI</h6>
                                <small class="text-muted">Kualitas Teruji &amp; Tersertifikasi</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded-3 bg-white border shadow-sm">
                            <i class="bi bi-clock-history text-danger fs-4"></i>
                            <div>
                                <h6 class="fw-bold text-navy mb-0" style="font-size: 0.9rem;">Pengerjaan Tepat Waktu</h6>
                                <small class="text-muted">Manajemen Proyek Terkontrol</small>
                            </div>
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
            <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">LAYANAN UTAMA</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Solusi Konstruksi Baja Terintegrasi</h2>
            <p class="text-muted mx-auto" style="max-width: 680px;">Setiap layanan dirancang untuk memberikan ketahanan struktur maksimal, efisiensi waktu pembangunan, dan keamanan operasional fasilitas bisnis Anda.</p>
        </div>

        @php
            $constructionServices = [
                [
                    'title' => 'Konstruksi Gudang Baja',
                    'desc' => 'Desain & pembangunan gudang bentang lebar tanpa tiang tengah, mengoptimalkan kapasitas penyimpanan dan kelancaran logistik.',
                    'icon' => 'bi-building-fill',
                    'img' => asset('images/konstruksi-gudang-baja.jpg')
                ],
                [
                    'title' => 'Konstruksi Pabrik Baja',
                    'desc' => 'Struktur pabrik industri heavy-duty yang dirancang khusus menahan beban mesin produksi dan crane operasional secara aman.',
                    'icon' => 'bi-building-gear',
                    'img' => asset('images/konstruksi-pabrik-baja.jpg')
                ],
                [
                    'title' => 'Konstruksi Hanggar Baja',
                    'desc' => 'Konstruksi bentang ekstra lebar dengan sistem rangka baja kokoh yang tahan terhadap angin dan cuaca ekstrem.',
                    'icon' => 'bi-airplane',
                    'img' => asset('images/konstruksi-hanggar-baja.jpg')
                ],
                [
                    'title' => 'Konstruksi Workshop Baja',
                    'desc' => 'Fasilitas kerja dan bengkel industri dengan efisiensi tata ruang tinggi, pencahayaan alami, dan sirkulasi udara optimal.',
                    'icon' => 'bi-tools',
                    'img' => asset('images/konstruksi-workshop-baja.jpg')
                ],
                [
                    'title' => 'Konstruksi Gedung Baja',
                    'desc' => 'Sistem struktur baja multilantai yang cepat dibangun, fleksibel untuk ekspansi, serta tahan beban gempa.',
                    'icon' => 'bi-building',
                    'img' => asset('images/konstruksi-struktur-gedung-baja.png')
                ],
                [
                    'title' => 'Konstruksi Mezzanine Baja',
                    'desc' => 'Solusi cepat menambah luas area kerja vertikal tanpa merusak struktur utama bangunan gudang atau pabrik.',
                    'icon' => 'bi-layers-half',
                    'img' => asset('images/konstruksi-mezzanine-baja.png')
                ],
                [
                    'title' => 'Rangka Atap Baja Bentang Lebar',
                    'desc' => 'Pemasangan rangka atap baja bervolume besar yang tahan korosi, kuat menahan beban, dan minim biaya perawatan.',
                    'icon' => 'bi-house-gear-fill',
                    'img' => asset('images/konstruksi-rangka-atap-baja.jpg')
                ],
                [
                    'title' => 'Renovasi & Perkuatan Struktur',
                    'desc' => 'Peningkatan kapasitas beban dan perkuatan struktur baja eksisting agar sesuai dengan kebutuhan operasional baru.',
                    'icon' => 'bi-shield-fill-check',
                    'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600&auto=format&fit=crop'
                ]
            ];
        @endphp

        <div class="row g-4">
            @foreach($constructionServices as $index => $item)
                <div class="col-md-6 col-lg-3 reveal" style="transition-delay: {{ 0.08 * ($index + 1) }}s;">
                    <div class="service-card h-100 border rounded-4 shadow-sm overflow-hidden bg-white d-flex flex-column">
                        <div class="card-img-wrapper" style="height: 180px; overflow: hidden; position: relative;">
                            <img src="{{ $item['img'] }}" class="w-100 h-100 object-fit-cover transition-zoom" alt="{{ $item['title'] }}">
                        </div>
                        <div class="card-body p-4 position-relative d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="service-icon-box mb-3">
                                    <i class="bi {{ $item['icon'] }}"></i>
                                </div>
                                <h5 class="card-title fw-bold text-navy mb-2 fs-6" style="line-height: 1.4;">{{ $item['title'] }}</h5>
                                <p class="text-muted text-sm mb-0" style="font-size: 0.85rem; line-height: 1.5;">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5 reveal">
            <a href="{{ route('public.services.index') }}" class="btn btn-accent btn-ripple px-4 py-2.5 text-white fw-semibold shadow-sm">
                Lihat Seluruh Layanan Konstruksi <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- Layanan Lainnya Section -->
<section id="other-services" class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">SOLUSI PENDUKUNG</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Layanan Sipil, Interior &amp; Arsitektur</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 720px; font-size: 0.95rem;">Untuk memberikan kemudahan One-Stop Solution, kami juga melayani pengerjaan sipil, mekanikal-elektrikal, serta penataan interior komersial secara profesional.</p>
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
                        ['title' => 'Renovasi Residensial & Komersial', 'desc' => 'Solusi renovasi gedung kantor, ruko, pabrik, dan fasilitas bisnis dengan pengerjaan rapi serta biaya efisien.', 'icon' => 'bi-house-gear-fill'],
                        ['title' => 'Design & Build Arsitektur', 'desc' => 'Layanan terpadu dari konsep desain arsitektur hingga eksekusi fisik bangunan dalam satu pintu.', 'icon' => 'bi-vector-pen'],
                        ['title' => 'Pekerjaan Sipil & MEP', 'desc' => 'Instalasi mekanikal, elektrikal, plumbing, dan perkerasan lantai beton sesuai regulasi keselamatan.', 'icon' => 'bi-lightning-charge-fill'],
                        ['title' => 'Workshop Custom Interior', 'desc' => 'Produksi furniture custom, partisi kantor, dan interior industri berstandar kualitas tinggi.', 'icon' => 'bi-hammer']
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
            <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">KEUNGGULAN KAMI</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Mengapa Memilih PT Multi Power Abadi?</h2>
            <p class="text-muted mx-auto" style="max-width: 650px;">Alasan utama mengapa pengembang properti, penyedia logistik, dan perusahaan manufaktur mempercayakan proyek struktur baja mereka kepada kami.</p>
        </div>
        <div class="row g-4 mt-2">
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.1s; margin-top: 25px;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card position-relative" style="padding-top: 2.5rem !important;">
                    <div class="why-choose-icon-box rounded-circle shadow d-flex align-items-center justify-content-center position-absolute" style="width: 50px; height: 50px; top: 0; left: 24px; transform: translateY(-50%); z-index: 10; border: 3px solid #ffffff; background-color: #dc2626; color: #ffffff;">
                        <i class="bi bi-patch-check-fill fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-navy mb-2 fs-5">Pengalaman Teruji</h4>
                        <p class="text-muted mb-0 text-sm" style="line-height: 1.6;">Berpengalaman lebih dari 12 tahun menyelesaikan ratusan gudang logistik, pabrik, dan gedung baja di berbagai kota Indonesia.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.2s; margin-top: 25px;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card position-relative" style="padding-top: 2.5rem !important;">
                    <div class="why-choose-icon-box rounded-circle shadow d-flex align-items-center justify-content-center position-absolute" style="width: 50px; height: 50px; top: 0; left: 24px; transform: translateY(-50%); z-index: 10; border: 3px solid #ffffff; background-color: #dc2626; color: #ffffff;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-navy mb-2 fs-5">Tenaga Ahli Berpengalaman</h4>
                        <p class="text-muted mb-0 text-sm" style="line-height: 1.6;">Tim engineer struktur, arsitek, dan pengawas proyek terlatih yang mengutamakan ketelitian teknis dan regulasi K3.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.3s; margin-top: 25px;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card position-relative" style="padding-top: 2.5rem !important;">
                    <div class="why-choose-icon-box rounded-circle shadow d-flex align-items-center justify-content-center position-absolute" style="width: 50px; height: 50px; top: 0; left: 24px; transform: translateY(-50%); z-index: 10; border: 3px solid #ffffff; background-color: #dc2626; color: #ffffff;">
                        <i class="bi bi-layers-fill fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-navy mb-2 fs-5">Material Standar SNI</h4>
                        <p class="text-muted mb-0 text-sm" style="line-height: 1.6;">Hanya menggunakan material baja WF, H-Beam, dan plat baja resmi bergaransi sertifikat uji tarik terpercaya.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.4s; margin-top: 25px;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card position-relative" style="padding-top: 2.5rem !important;">
                    <div class="why-choose-icon-box rounded-circle shadow d-flex align-items-center justify-content-center position-absolute" style="width: 50px; height: 50px; top: 0; left: 24px; transform: translateY(-50%); z-index: 10; border: 3px solid #ffffff; background-color: #dc2626; color: #ffffff;">
                        <i class="bi bi-alarm-fill fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-navy mb-2 fs-5">Pengerjaan Tepat Waktu</h4>
                        <p class="text-muted mb-0 text-sm" style="line-height: 1.6;">Fasilitas fabrikasi mandiri dan rantai pasok terintegrasi memastikan pengerjaan proyek tepat waktu tanpa *delay*.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.5s; margin-top: 25px;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card position-relative" style="padding-top: 2.5rem !important;">
                    <div class="why-choose-icon-box rounded-circle shadow d-flex align-items-center justify-content-center position-absolute" style="width: 50px; height: 50px; top: 0; left: 24px; transform: translateY(-50%); z-index: 10; border: 3px solid #ffffff; background-color: #dc2626; color: #ffffff;">
                        <i class="bi bi-shield-fill-exclamation fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-navy mb-2 fs-5">Standar Keselamatan K3</h4>
                        <p class="text-muted mb-0 text-sm" style="line-height: 1.6;">Penerapan Sistem Manajemen K3 ketat untuk mencapai *Zero Accident* dan menjaga keamanan seluruh pekerja lapangan.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 reveal" style="transition-delay: 0.6s; margin-top: 25px;">
                <div class="bg-white p-4 rounded-4 shadow-sm border h-100 transition-hover-card position-relative" style="padding-top: 2.5rem !important;">
                    <div class="why-choose-icon-box rounded-circle shadow d-flex align-items-center justify-content-center position-absolute" style="width: 50px; height: 50px; top: 0; left: 24px; transform: translateY(-50%); z-index: 10; border: 3px solid #ffffff; background-color: #dc2626; color: #ffffff;">
                        <i class="bi bi-award-fill fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold text-navy mb-2 fs-5">Garansi &amp; Layanan Purna Jual</h4>
                        <p class="text-muted mb-0 text-sm" style="line-height: 1.6;">Jaminan garansi pemeliharaan pasca serah terima untuk memastikan kepuasan dan ketenangan investasi Anda.</p>
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
                <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">REKAM JEJAK PROYEK</span>
                <h2 class="mt-2 display-6 fw-bold text-navy">Dokumentasi Proyek Sukses</h2>
                <p class="text-muted mb-0" style="max-width: 600px;">Bukti keandalan struktur baja dan kepuasan klien di berbagai lokasi industri.</p>
            </div>
            <!-- Dynamic project filter buttons -->
            <div class="filter-btn-group d-flex flex-wrap gap-2 mt-3 mt-lg-0">
                <button type="button" class="btn filter-btn active" data-filter="all">Semua Proyek</button>
                <button type="button" class="btn filter-btn" data-filter="Mezzanine">Mezzanine</button>
                <button type="button" class="btn filter-btn" data-filter="Gedung">Gedung Industri</button>
            </div>
        </div>

        <div class="row g-4">
            @forelse($projects as $project)
                <div class="col-md-6 col-lg-4 project-showcase-item reveal" data-category="{{ $project->category }}">
                    <div class="project-card project-card-clickable border rounded-4 overflow-hidden position-relative shadow-sm"
                         style="height: 290px; cursor: pointer;"
                         data-title="{{ $project->title }}"
                         data-category="{{ $project->category }}"
                         data-location="{{ $project->location }}"
                         data-year="{{ $project->year }}"
                         data-description="{{ $project->description ?: 'Proyek konstruksi baja berkualitas tinggi yang diselesaikan tepat waktu oleh PT Multi Power Abadi.' }}"
                         data-image="{{ $project->image ? asset('storage/' . $project->image) : ($project->category === 'Mezzanine' ? asset('images/konstruksi-mezzanine-kosmetika.jpg') : asset('images/gudang-pabrik.jpg')) }}"
                         onclick="openProjectPopup(this)">
                        <img src="{{ $project->image ? asset('storage/' . $project->image) : ($project->category === 'Mezzanine' ? asset('images/konstruksi-mezzanine-kosmetika.jpg') : asset('images/gudang-pabrik.jpg')) }}" class="w-100 h-100 object-fit-cover transition-zoom" alt="{{ $project->title }}">
                        <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy">
                            <span class="project-card-category badge bg-danger text-white fw-semibold text-uppercase text-xs mb-2 align-self-start shadow-sm" style="letter-spacing: 0.8px;">{{ $project->category }}</span>
                            <h4 class="project-card-title text-white fw-bold my-1" style="font-size: 1.15rem;">{{ $project->title }}</h4>
                            <div class="project-card-location text-white-50 small">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $project->location }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback static projects if DB is empty -->
                @php
                    $staticProjects = [
                        [
                            'title' => 'Konstruksi Mezzanine Industri – PT Kosmetika Global Indonesia',
                            'category' => 'Mezzanine',
                            'location' => 'Rungkut Industri III, Surabaya',
                            'year' => 2024,
                            'description' => 'Pembangunan struktur mezzanine baja heavy-duty untuk perluasan kapasitas ruang operasional pabrik kosmetik tanpa mengganggu alur kerja eksisting.',
                            'image' => asset('images/konstruksi-mezzanine-kosmetika.jpg')
                        ],
                        [
                            'title' => 'Konstruksi Mezzanine Logistik – PT Hore Indonesia Sehat',
                            'category' => 'Mezzanine',
                            'location' => 'Kawasan Industri Driyorejo, Gresik',
                            'year' => 2025,
                            'description' => 'Pekerjaan rangka baja mezzanine untuk optimalisasi ruang penyimpanan gudang medis berstandar higienitas tinggi.',
                            'image' => asset('images/konstruksi-mezzanine-hore.jpg')
                        ],
                        [
                            'title' => 'Gedung Kantor Rangka Baja – PT Telekomunikasi Indonesia',
                            'category' => 'Gedung',
                            'location' => 'Margorejo Indah, Surabaya',
                            'year' => 2025,
                            'description' => 'Pembangunan struktur gedung perkantoran bertingkat berbasis rangka baja kuat, presisi, dan selesai tepat waktu.',
                            'image' => asset('images/pembangunan-gedung-telkom.jpg')
                        ]
                    ];
                @endphp
                @foreach($staticProjects as $item)
                    <div class="col-md-6 col-lg-4 project-showcase-item reveal" data-category="{{ $item['category'] }}">
                        <div class="project-card project-card-clickable border rounded-4 overflow-hidden position-relative shadow-sm"
                             style="height: 280px; cursor: pointer;"
                             data-title="{{ $item['title'] }}"
                             data-category="{{ $item['category'] }}"
                             data-location="{{ $item['location'] }}"
                             data-year="{{ $item['year'] }}"
                             data-description="{{ $item['description'] }}"
                             data-image="{{ $item['image'] }}"
                             onclick="openProjectPopup(this)">
                            <img src="{{ $item['image'] }}" class="w-100 h-100 object-fit-cover transition-zoom" alt="{{ $item['title'] }}">
                            <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy">
                                <span class="project-card-category badge bg-danger text-white fw-semibold text-uppercase text-xs mb-2 align-self-start shadow-sm" style="letter-spacing: 0.8px;">{{ $item['category'] }}</span>
                                <h4 class="project-card-title text-white fw-bold my-1" style="font-size: 1.15rem;">{{ $item['title'] }}</h4>
                                <div class="project-card-location text-white-50 small">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $item['location'] }}
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
            <h2 class="mt-2 display-6 fw-bold text-navy">Dipercaya Oleh Perusahaan Terkemuka</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 700px; font-size: 0.95rem;">Kami bangga dapat menjalin hubungan kemitraan jangka panjang dengan berbagai BUMN, penyedia logistik, pengembang properti, dan manufaktur skala nasional.</p>
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

<!-- Call to Action Section — Floating Card -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="position-relative overflow-hidden rounded-4 shadow-lg text-center p-4 p-md-5 reveal" style="background-image: url('https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=1600&auto=format&fit=crop'); background-size: cover; background-position: center; z-index: 1;">
            <!-- Dark Overlay inside the card -->
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(15, 23, 42, 0.94); z-index: 2;"></div>
            
            <!-- Content -->
            <div class="position-relative py-2 py-md-3" style="z-index: 3;">
                <span class="badge bg-danger text-white px-3 py-2 rounded-pill text-uppercase mb-3 d-inline-block shadow-sm text-wrap" style="letter-spacing: 1px; max-width: 100%;">KONSULTASI GRATIS &amp; PENAWARAN HARGA</span>
                <h2 class="fs-2 text-white fw-bold mb-3 mx-auto" style="max-width: 680px; line-height: 1.35;">Siap Mewujudkan Proyek Bangunan &amp; Gudang Baja Anda?</h2>
                <p class="lead text-white-50 mb-4 mx-auto" style="max-width: 700px; font-size: 1.05rem; line-height: 1.6;">Dapatkan konsultasi gratis teknis rekayasa struktur dan estimasi penawaran harga terbaik dari tim engineer ahli PT Multi Power Abadi.</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('public.quotation') }}" class="btn btn-accent btn-lg btn-ripple text-white fw-semibold px-4 shadow">
                        <i class="bi bi-file-earmark-spreadsheet-fill me-2"></i>Minta Penawaran Proyek
                    </a>
                    <a href="https://wa.me/62811272825" target="_blank" rel="noopener noreferrer" class="btn btn-outline-white btn-lg btn-ripple px-4 fw-semibold">
                        <i class="bi bi-whatsapp me-2"></i>Hubungi Tim Kami (WhatsApp)
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
