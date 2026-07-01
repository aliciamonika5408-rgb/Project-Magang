@extends('layouts.public')

@section('title', $service->title . ' - PT Multi Power Abadi')

@section('content')
<!-- Page Header -->
<div class="bg-navy text-white py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F2D5C 0%, #0a1f40 100%);">
    <div class="container py-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.services.index') }}" class="text-white-50 text-decoration-none">Services</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $service->title }}</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold text-white mb-0 mt-3">{{ $service->title }}</h1>
    </div>
</div>

<!-- Details & Sidebar Section -->
<div class="py-5 bg-white">
    <div class="container">
        <div class="row g-5">
            <!-- Main Content Column -->
            <div class="col-lg-8 reveal reveal-left">
                <!-- Service Featured Image -->
                <div class="rounded-4 overflow-hidden mb-4 shadow-sm" style="max-height: 450px;">
                    <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=1200&auto=format&fit=crop' }}" class="w-100 h-100 object-fit-cover" alt="{{ $service->title }}">
                </div>
                
                <h3 class="fw-bold text-navy mb-3">Deskripsi Layanan</h3>
                <div class="text-muted leading-relaxed mb-4">
                    {!! nl2br(e($service->description)) !!}
                </div>

                @if($service->content)
                    <h3 class="fw-bold text-navy mt-5 mb-3">Rincian & Cakupan Pekerjaan</h3>
                    <div class="text-muted leading-relaxed mb-5">
                        {!! $service->content !!}
                    </div>
                @endif

                <!-- Service Advantages -->
                <div class="bg-light p-4 rounded-4 border mt-5">
                    <h4 class="fw-bold text-navy mb-3"><i class="bi bi-shield-check text-warning me-2"></i>Komitmen Mutu Layanan</h4>
                    <p class="text-muted text-sm">Setiap pengerjaan layanan {{ $service->title }} di PT Multi Power Abadi mengikuti aturan keselamatan standar nasional (K3) serta pelaporan progres terperinci setiap minggu.</p>
                    <ul class="list-unstyled row g-2 mt-3">
                        <li class="col-sm-6 d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-warning"></i>
                            <span class="text-muted text-sm">Baja WF & Profil bersertifikat SNI</span>
                        </li>
                        <li class="col-sm-6 d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-warning"></i>
                            <span class="text-muted text-sm">Penyusunan RAB Terperinci</span>
                        </li>
                        <li class="col-sm-6 d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-warning"></i>
                            <span class="text-muted text-sm">Metode Ereksi Baja Aman & Presisi</span>
                        </li>
                        <li class="col-sm-6 d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-warning"></i>
                            <span class="text-muted text-sm">Masa Pemeliharaan Struktur</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="col-lg-4 reveal reveal-right" style="transition-delay: 0.2s;">
                <!-- Sidebar Service Navigation -->
                <div class="card border rounded-4 p-4 shadow-sm mb-4 bg-light">
                    <h5 class="fw-bold text-navy mb-3">Layanan Lainnya</h5>
                    <div class="list-group list-group-flush rounded-3 overflow-hidden border">
                        @foreach($otherServices as $other)
                            <a href="{{ route('public.services.detail', $other->slug) }}" class="list-group-item list-group-item-action text-navy py-3 px-3 d-flex align-items-center justify-content-between">
                                <span class="fw-semibold">{{ $other->title }}</span>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Quotation Request CTA Card -->
                <div class="card bg-navy text-white rounded-4 p-4 shadow-sm text-center">
                    <h4 class="fw-bold mb-2 text-white">Ingin Diskusi Desain Proyek?</h4>
                    <p class="text-white-50 text-sm mb-4">Konsultasikan denah tapak, bentang struktur baja, maupun tonase konstruksi Anda langsung dengan tim estimator.</p>
                    <a href="{{ route('public.quotation') }}" class="btn btn-warning btn-block btn-ripple text-navy fw-semibold py-3 shadow">
                        Mulai Konsultasi Gratis
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
