@extends('layouts.public')

@section('title', 'Klien & Rekanan Kerja - PT Multi Power Abadi')

@section('content')
<!-- Page Header -->
<div class="bg-navy text-white py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F2D5C 0%, #0a1f40 100%);">
    <div class="container py-4 text-center">
        <h1 class="display-4 fw-bold mb-2 text-white">Klien & Rekanan</h1>
        <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
            Mitra kerja industri dan korporasi yang telah mempercayakan konstruksi bangunannya kepada kami.
        </p>
    </div>
</div>

<!-- Partner Logotypes Grid -->
<div class="py-5 bg-light">
    <div class="container py-3">
        <div class="text-center mb-5 reveal">
            <h2 class="fw-bold text-navy">Dipercaya Oleh Berbagai Perusahaan</h2>
            <p class="text-muted">Kami menjalin kemitraan erat dengan berbagai pengembang properti komersial, penyedia logistik, dan manufaktur berskala nasional.</p>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($clients as $client)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 reveal">
                    <div class="bg-white border rounded-4 p-3 d-flex align-items-center justify-content-center shadow-sm" style="height: 100px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                        <img src="{{ asset('storage/' . $client->logo_path) }}" class="img-fluid object-fit-contain" style="max-height: 70px;" alt="{{ $client->name }}">
                    </div>
                </div>
            @empty
                <!-- Fallback clients -->
                @for($i = 1; $i <= 8; $i++)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2 reveal">
                        <div class="bg-white border rounded-4 p-3 d-flex align-items-center justify-content-center shadow-sm" style="height: 100px;">
                            <h6 class="fw-bold text-muted mb-0">PARTNER {{ $i }}</h6>
                        </div>
                    </div>
                @endfor
            @endforelse
        </div>
    </div>
</div>

<!-- Testimonials Carousel Section -->
<div class="py-5 bg-white border-top">
    <div class="container py-3">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-warning" style="letter-spacing: 2px;">Testimoni</span>
            <h2 class="mt-2 fw-bold text-navy">Apa Kata Mereka Tentang Kami?</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-6 reveal reveal-left">
                <div class="bg-light p-4 rounded-4 border shadow-sm h-100 position-relative">
                    <span class="position-absolute top-0 end-0 m-3 text-warning fs-1"><i class="bi bi-quote"></i></span>
                    <p class="text-muted leading-relaxed mb-4">"PT Multi Power Abadi berhasil merampungkan gudang logistik kami seluas 8.500 m2 di Karawang lebih cepat 3 minggu dari jadwal rencana kontrak kerja. Kualitas pengelasan baja rapi, lurus, dan lulus inspeksi lapangan."</p>
                    <h5 class="fw-bold text-navy mb-1">Budi Santoso</h5>
                    <span class="text-warning text-xs fw-semibold">Operations Director, PT Logistik Nusantara</span>
                </div>
            </div>
            
            <div class="col-md-6 reveal reveal-right" style="transition-delay: 0.2s;">
                <div class="bg-light p-4 rounded-4 border shadow-sm h-100 position-relative">
                    <span class="position-absolute top-0 end-0 m-3 text-warning fs-1"><i class="bi bi-quote"></i></span>
                    <p class="text-muted leading-relaxed mb-4">"Pekerjaan steel erection dan fabrikasi baja di workshop mereka dilakukan sangat presisi. Seluruh kolom baja terpancang tegak tanpa ada kesalahan lubang angkur baut pondasi. Sangat direkomendasikan."</p>
                    <h5 class="fw-bold text-navy mb-1">Ir. Hendra Wijaya</h5>
                    <span class="text-warning text-xs fw-semibold">Project Director, Wijaya Property Indonesia</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
