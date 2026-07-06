@extends('layouts.public')

@section('title', 'Portfolio Proyek Konstruksi & Struktur Baja - PT Multi Power Abadi')

@section('content')
<!-- Page Header -->
<div class="page-header-banner bg-navy text-white position-relative overflow-hidden d-flex align-items-center" style="background: linear-gradient(135deg, rgba(15, 45, 92, 0.85) 0%, rgba(10, 31, 64, 0.88) 100%), url('{{ asset('images/page-header-bg.jpg') }}') center/cover no-repeat !important; padding-top: 170px; padding-bottom: 160px; min-height: 400px;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-2 text-white">Portfolio Proyek</h1>
        <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
            Dokumentasi pekerjaan konstruksi gudang logistik, fabrikasi besi baja, dan ereksi struktur industri.
        </p>
    </div>
</div>

<!-- Search & Filtering Bar -->
<div class="py-4 bg-light border-bottom border-light">
    <div class="container">
        <form action="{{ route('public.projects.index') }}" method="GET" class="row g-3 align-items-center">
            <!-- Search Input -->
            <div class="col-md-5">
                <div class="input-group bg-white rounded-3 shadow-sm border overflow-hidden">
                    <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-0 py-2 px-1" placeholder="Cari nama proyek, lokasi..." value="{{ request('search') }}">
                </div>
            </div>
            
            <!-- Category Filter Selection -->
            <div class="col-md-4">
                <div class="input-group bg-white rounded-3 shadow-sm border overflow-hidden">
                    <span class="input-group-text bg-white border-0 text-muted"><i class="bi bi-filter"></i></span>
                    <select name="category" class="form-select border-0 py-2 px-1" onchange="this.form.submit()">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Action Button -->
            <div class="col-md-3">
                <button type="submit" class="btn btn-navy btn-ripple w-100 py-2 text-white shadow fw-semibold">Cari & Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Projects Grid Showcase -->
<div class="py-5 bg-white">
    <div class="container py-3">
        <div class="row g-4">
            @forelse($projects as $index => $project)
                <div class="col-md-6 col-lg-4 reveal" style="transition-delay: {{ 0.1 * ($index % 3 + 1) }}s;">
                    <div class="project-card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="height: 310px;">
                        <img src="{{ $project->image ? asset('storage/' . $project->image) : asset('images/gudang-pabrik.jpg') }}" 
                             class="project-card-img w-100 h-100 object-fit-cover" 
                             alt="{{ $project->title }}">
                        
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
                    <div class="col-md-6 col-lg-4 reveal">
                        <div class="project-card border-0 rounded-4 overflow-hidden position-relative shadow-sm" style="height: 310px;">
                            <img src="{{ $item['image'] }}" class="project-card-img w-100 h-100 object-fit-cover" alt="{{ $item['title'] }}">
                            
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

        @if(method_exists($projects, 'links'))
            <div class="d-flex justify-content-center mt-5">
                {{ $projects->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

@endsection
