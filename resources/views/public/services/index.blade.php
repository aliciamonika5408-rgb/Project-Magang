@extends('layouts.public')

@section('title', 'Layanan Konstruksi & Fabrikasi Baja - PT Multi Power Abadi')

@section('content')
<!-- Page Header -->
<div class="bg-navy text-white py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F2D5C 0%, #0a1f40 100%);">
    <div class="container py-4 text-center">
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
                        <div class="card-body p-4 position-relative">
                            <div class="service-icon-box bg-navy text-white rounded-3 d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 50px; height: 50px; font-size: 1.5rem;">
                                <i class="bi {{ $service->icon ?? 'bi-building' }}"></i>
                            </div>
                            <h4 class="card-title fw-bold text-navy mb-2">{{ $service->title }}</h4>
                            <p class="text-muted mb-3">{{ Str::limit($service->description, 130) }}</p>
                            <a href="{{ route('public.services.detail', $service->slug) }}" class="text-warning text-decoration-none fw-semibold">
                                Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Static Fallback Services -->
                @php
                    $staticServices = [
                        ['title' => 'Konstruksi Gudang', 'slug' => 'konstruksi-gudang', 'desc' => 'Desain & pembangunan gudang skala kecil hingga logistik enterprise dengan bentang lebar tanpa tiang tengah.', 'icon' => 'bi-building-fill-add', 'img' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Konstruksi Baja', 'slug' => 'konstruksi-baja', 'desc' => 'Struktur baja berat untuk pabrik, gedung bertingkat, hangar pesawat, dengan kestabilan seismik optimal.', 'icon' => 'bi-cone-striped', 'img' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Fabrikasi Baja', 'slug' => 'fabrikasi-baja', 'desc' => 'Pemotongan, pembentukan, pengeboran, dan pengelasan plat & profil baja di workshop tersertifikasi milik kami.', 'icon' => 'bi-tools', 'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Steel Erection', 'slug' => 'steel-erection', 'desc' => 'Pemasangan komponen struktur baja di lapangan secara cepat, akurat, aman dengan tim crane bersertifikat.', 'icon' => 'bi-wrench-adjustable', 'img' => 'https://images.unsplash.com/photo-1581094288338-2314dddb7ecc?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Bangunan Industri', 'slug' => 'bangunan-industri', 'desc' => 'Pembangunan pabrik kimia, pengolahan makanan, workshop industri lengkap dengan utilitas kelistrikan & ducting.', 'icon' => 'bi-industry', 'img' => 'https://images.unsplash.com/photo-1516937941344-00b4e0337589?q=80&w=600&auto=format&fit=crop']
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
                                <a href="#" class="text-warning text-decoration-none fw-semibold">
                                    Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                </a>
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

<!-- CTA Request Quotation -->
<section class="py-5 bg-navy text-white text-center border-top">
    <div class="container py-3 reveal">
        <h3 class="fw-bold mb-3 text-white">Butuh Solusi Khusus Untuk Proyek Industri Anda?</h3>
        <p class="text-white-50 mb-4 mx-auto" style="max-width: 600px;">Kami melayani penyesuaian desain, perhitungan tonase baja, RAB, serta estimasi masa pengerjaan proyek konstruksi.</p>
        <a href="{{ route('public.quotation') }}" class="btn btn-warning btn-lg btn-ripple text-navy fw-semibold px-4 shadow">Ajukan Penawaran Proyek</a>
    </div>
</section>
@endsection
