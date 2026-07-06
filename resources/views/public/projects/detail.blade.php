@extends('layouts.public')

@section('title', $project->title . ' - PT Multi Power Abadi')

@section('content')
<!-- Page Header -->
<div class="page-header-banner bg-navy text-white position-relative overflow-hidden d-flex align-items-center" style="background: linear-gradient(135deg, rgba(15, 45, 92, 0.85) 0%, rgba(10, 31, 64, 0.88) 100%), url('{{ asset('images/page-header-bg.jpg') }}') center/cover no-repeat !important; padding-top: 170px; padding-bottom: 160px; min-height: 400px;">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.projects.index') }}" class="text-white-50 text-decoration-none">Projects</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $project->title }}</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold text-white mb-0 mt-3">{{ $project->title }}</h1>
    </div>
</div>

<!-- Details & Info Cards -->
<div class="py-5 bg-white">
    <div class="container">
        <div class="row g-5">
            <!-- Left: Description and Gallery -->
            <div class="col-lg-8 reveal reveal-left">
                <!-- Primary Image -->
                <div class="rounded-4 overflow-hidden mb-4 shadow-sm" style="max-height: 480px;">
                    <img src="{{ $project->image ? asset('storage/' . $project->image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1200&auto=format&fit=crop' }}" class="w-100 h-100 object-fit-cover" alt="{{ $project->title }}">
                </div>

                <h3 class="fw-bold text-navy mb-3">Rincian Proyek</h3>
                <div class="text-muted leading-relaxed mb-5">
                    {!! nl2br(e($project->description)) !!}
                </div>

                <!-- Secondary Gallery Images -->
                @if($project->images->count() > 0)
                    <h3 class="fw-bold text-navy mb-4">Galeri Dokumentasi Lapangan</h3>
                    <div class="row g-3">
                        @foreach($project->images as $galImage)
                            <div class="col-sm-6 col-md-4">
                                <div class="rounded-3 overflow-hidden shadow-sm position-relative border" style="height: 160px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.03)'" onmouseout="this.style.transform='scale(1)'">
                                    <a href="{{ asset('storage/' . $galImage->image_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $galImage->image_path) }}" class="w-100 h-100 object-fit-cover" alt="Proyek Dokumentasi">
                                        <div class="position-absolute start-0 top-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-25 opacity-0 hover-opacity-100 transition-smooth" style="transition: 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                                            <i class="bi bi-zoom-in text-white fs-3"></i>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right: Project Meta Sidebar -->
            <div class="col-lg-4 reveal reveal-right" style="transition-delay: 0.2s;">
                <div class="card border rounded-4 shadow-sm p-4 bg-light mb-4">
                    <h5 class="fw-bold text-navy mb-4 border-bottom pb-2">Informasi Proyek</h5>
                    <div class="mb-3">
                        <span class="text-muted text-xs d-block mb-1">KATEGORI</span>
                        <strong class="text-navy fs-6">{{ $project->category }}</strong>
                    </div>
                    <div class="mb-3">
                        <span class="text-muted text-xs d-block mb-1">LOKASI</span>
                        <strong class="text-navy fs-6"><i class="bi bi-geo-alt-fill text-warning me-1"></i>{{ $project->location }}</strong>
                    </div>
                    <div class="mb-3">
                        <span class="text-muted text-xs d-block mb-1">TAHUN RAMPUNG</span>
                        <strong class="text-navy fs-6">{{ $project->year }}</strong>
                    </div>
                    @if($project->client_name)
                        <div class="mb-3">
                            <span class="text-muted text-xs d-block mb-1">NAMA KLIEN</span>
                            <strong class="text-navy fs-6">{{ $project->client_name }}</strong>
                        </div>
                    @endif
                    @if($project->budget)
                        <div class="mb-0">
                            <span class="text-muted text-xs d-block mb-1">ESTIMASI ANGGARAN</span>
                            <strong class="text-navy fs-6">{{ $project->budget }}</strong>
                        </div>
                    @endif
                </div>

                <!-- Related Projects -->
                @if($relatedProjects->count() > 0)
                    <div class="card border rounded-4 shadow-sm p-4 bg-white mb-4">
                        <h5 class="fw-bold text-navy mb-3">Proyek Sejenis</h5>
                        <div class="list-group list-group-flush">
                            @foreach($relatedProjects as $rel)
                                <a href="{{ route('public.projects.detail', $rel->slug) }}" class="list-group-item list-group-item-action py-3 px-0 d-flex align-items-center gap-3">
                                    <img src="{{ $rel->image ? asset('storage/' . $rel->image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=150&auto=format&fit=crop' }}" class="rounded" style="width: 70px; height: 50px; object-fit: cover;" alt="{{ $rel->title }}">
                                    <div>
                                        <h6 class="fw-bold text-navy mb-1 text-truncate" style="max-width: 190px;">{{ $rel->title }}</h6>
                                        <span class="text-muted text-xs">{{ $rel->location }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- CTA -->
                <div class="card bg-navy text-white rounded-4 p-4 shadow-sm text-center">
                    <h5 class="fw-bold mb-2 text-white">Butuh Konstruksi Serupa?</h5>
                    <p class="text-white-50 text-sm mb-4">Konsultasikan kebutuhan gambar teknik (DED) dan perhitungan estimasi anggaran baja Anda.</p>
                    <a href="{{ route('public.quotation') }}" class="btn btn-warning btn-block btn-ripple text-navy fw-semibold py-3 shadow">
                        Mulai Konsultasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
