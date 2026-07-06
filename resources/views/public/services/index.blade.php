@extends('layouts.public')

@section('title', 'Layanan Konstruksi & Fabrikasi Baja - PT Multi Power Abadi')

@section('content')
<!-- Page Header -->
<div class="page-header-banner bg-navy text-white position-relative overflow-hidden d-flex align-items-center" style="background: linear-gradient(135deg, rgba(15, 45, 92, 0.85) 0%, rgba(10, 31, 64, 0.88) 100%), url('{{ asset('images/page-header-bg.jpg') }}') center/cover no-repeat !important; padding-top: 170px; padding-bottom: 160px; min-height: 400px;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-2 text-white">Layanan Konstruksi</h1>
        <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
            Solusi rancang bangun industri terintegrasi dengan tim engineering handal dan pengawasan mutu bersertifikasi.
        </p>
    </div>
</div>

<!-- Services Grid -->
<div class="py-5 bg-light">
    <div class="container py-3">
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
                                <p class="text-muted mb-3">{{ Str::limit($service->description, 130) }}</p>
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
                <!-- Static Fallback Services -->
                @php
                    $staticServices = [
                        ['title' => 'Konstruksi Gudang', 'slug' => 'konstruksi-gudang', 'desc' => 'Desain & pembangunan gudang skala kecil hingga logistik enterprise dengan bentang lebar tanpa tiang tengah.', 'icon' => 'bi-building-fill-add', 'img' => asset('images/gudang-pabrik.jpg')],
                        ['title' => 'Konstruksi Baja', 'slug' => 'konstruksi-baja', 'desc' => 'Struktur baja berat untuk pabrik, gedung bertingkat, hangar pesawat, dengan kestabilan seismik optimal.', 'icon' => 'bi-cone-striped', 'img' => asset('images/konstruksi-baja.jpg')],
                        ['title' => 'Fabrikasi Baja', 'slug' => 'fabrikasi-baja', 'desc' => 'Pemotongan, pembentukan, pengeboran, dan pengelasan plat & profil baja di workshop tersertifikasi milik kami.', 'icon' => 'bi-tools', 'img' => asset('images/fabrikasi-baja.jpg')],
                        ['title' => 'Steel Erection', 'slug' => 'steel-erection', 'desc' => 'Pemasangan komponen struktur baja di lapangan secara cepat, akurat, aman dengan tim crane bersertifikat.', 'icon' => 'bi-wrench-adjustable', 'img' => asset('images/steel-erection.jpg')],
                        ['title' => 'Bangunan Industri', 'slug' => 'bangunan-industri', 'desc' => 'Pembangunan pabrik kimia, pengolahan makanan, workshop industri lengkap dengan utilitas kelistrikan & ducting.', 'icon' => 'bi-industry', 'img' => asset('images/bangunan-industri.jpg')]
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
                                    <a href="#" class="btn-service-more">
                                        <span>Selengkapnya</span> <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
        
        @if(method_exists($services, 'links'))
            <div class="d-flex justify-content-center mt-5">
                {{ $services->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

<!-- Layanan Lainnya Section -->
<section id="other-services" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">LAYANAN DUKUNGAN</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Layanan Lainnya</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 720px; font-size: 0.95rem;">Selain sebagai kontraktor baja, PT. Multi Power Abadi juga menyediakan berbagai layanan konstruksi dan interior untuk memenuhi kebutuhan proyek residensial maupun komersial.</p>
        </div>

        @php
            $otherServices = [
                [
                    'title' => 'Konstruksi Renovasi Residensial & Komersial',
                    'desc' => 'Melayani renovasi rumah, gedung perkantoran, ruko, toko, restoran, dan bangunan komersial dengan hasil yang berkualitas dan sesuai kebutuhan klien.',
                    'icon' => 'bi-house-gear-fill'
                ],
                [
                    'title' => 'Design Build Arsitektur & Interior',
                    'desc' => 'Menyediakan layanan desain arsitektur, desain interior, hingga pembangunan secara menyeluruh dalam satu proses yang terintegrasi.',
                    'icon' => 'bi-vector-pen'
                ],
                [
                    'title' => 'Pekerjaan Sipil, Mekanikal, Elektrikal & Plumbing (CMEP)',
                    'desc' => 'Menangani pekerjaan sipil, instalasi mekanikal, elektrikal, plumbing, serta sistem pendukung bangunan sesuai standar konstruksi.',
                    'icon' => 'bi-lightning-charge-fill'
                ],
                [
                    'title' => 'Workshop Furniture & Custom Interior',
                    'desc' => 'Memproduksi berbagai furniture custom, kitchen set, office furniture, partisi, serta kebutuhan interior sesuai desain dan spesifikasi proyek.',
                    'icon' => 'bi-hammer'
                ]
            ];
        @endphp

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-2">
            @foreach($otherServices as $index => $service)
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
        </div>
    </div>
</section>

<!-- CTA Request Quotation -->
<section class="py-5 bg-navy text-white text-center">
    <div class="container py-3 reveal">
        <h3 class="fw-bold mb-3 text-white">Butuh Solusi Khusus Untuk Proyek Industri Anda?</h3>
        <p class="text-white-50 mb-4 mx-auto" style="max-width: 600px;">Kami melayani penyesuaian desain, perhitungan tonase baja, RAB, serta estimasi masa pengerjaan proyek konstruksi.</p>
        <a href="{{ route('public.quotation') }}" class="btn btn-warning btn-lg btn-ripple text-navy fw-semibold px-4 shadow">Ajukan Penawaran Proyek</a>
    </div>
</section>
@endsection
