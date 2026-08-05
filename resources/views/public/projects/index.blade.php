@extends('layouts.public')

@section('title', 'Portfolio Proyek Konstruksi & Struktur Baja - PT Multi Power Abadi')

@section('content')
<!-- Page Header -->
<div class="page-header-banner text-white position-relative overflow-hidden d-flex align-items-center" style="padding-top: 170px; padding-bottom: 160px; min-height: 400px;">
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
                    <div class="project-card project-card-clickable border-0 rounded-4 overflow-hidden position-relative shadow-sm"
                         style="height: 310px; cursor: pointer;"
                         data-title="{{ $project->title }}"
                         data-category="{{ $project->category }}"
                         data-location="{{ $project->location }}"
                         data-year="{{ $project->year }}"
                         data-description="{{ $project->description ?: 'Proyek konstruksi baja oleh PT Multi Power Abadi.' }}"
                         data-image="{{ $project->image ? asset('storage/' . $project->image) : ($project->category === 'Mezzanine' ? asset('images/konstruksi-mezzanine-kosmetika.jpg') : asset('images/gudang-pabrik.jpg')) }}"
                         onclick="openProjectPopup(this)">
                        <img src="{{ $project->image ? asset('storage/' . $project->image) : ($project->category === 'Mezzanine' ? asset('images/konstruksi-mezzanine-kosmetika.jpg') : asset('images/gudang-pabrik.jpg')) }}" 
                             class="project-card-img w-100 h-100 object-fit-cover" 
                             alt="{{ $project->title }}">
                        <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy">
                            <span class="project-card-category badge bg-danger text-white fw-semibold text-uppercase text-xs mb-2 align-self-start shadow-sm" style="letter-spacing: 0.8px;">{{ $project->category }}</span>
                            <h4 class="project-card-title text-white fw-bold my-1" style="font-size: 1.2rem;">{{ $project->title }}</h4>
                            <div class="project-card-location text-white-50 small">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $project->location }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                @php
                    $staticProjects = [
                        [
                            'title' => 'Konstruksi Mezzanine – PT Kosmetika Global Indonesia',
                            'category' => 'Mezzanine',
                            'location' => 'Jl. Rungkut Industri III No. 9, Kel. Kutisari, Kec. Tenggilis Mejoyo, Surabaya',
                            'year' => 2024,
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                            'image' => asset('images/konstruksi-mezzanine-kosmetika.jpg')
                        ],
                        [
                            'title' => 'Konstruksi Mezzanine – PT Hore Indonesia Sehat',
                            'category' => 'Mezzanine',
                            'location' => 'Jl. Raya Bambe BLOK K-06, Area Sawah, Bambe, Driyorejo, Gresik Regency',
                            'year' => 2025,
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                            'image' => asset('images/konstruksi-mezzanine-hore.jpg')
                        ],
                        [
                            'title' => 'Pembangunan Gedung Kantor dengan Struktur Baja - PT Telekomunikasi Indonesia',
                            'category' => 'Gedung',
                            'location' => 'Jl. Margorejo Indah No. 56A/136, Margorejo, Wonocolo, Surabaya',
                            'year' => 2025,
                            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                            'image' => asset('images/pembangunan-gedung-telkom.jpg')
                        ]
                    ];
                @endphp
                @foreach($staticProjects as $item)
                    <div class="col-md-6 col-lg-4 reveal">
                        <div class="project-card project-card-clickable border-0 rounded-4 overflow-hidden position-relative shadow-sm"
                             style="height: 310px; cursor: pointer;"
                             data-title="{{ $item['title'] }}"
                             data-category="{{ $item['category'] }}"
                             data-location="{{ $item['location'] }}"
                             data-year="{{ $item['year'] }}"
                             data-description="{{ $item['description'] }}"
                             data-image="{{ $item['image'] }}"
                             onclick="openProjectPopup(this)">
                            <img src="{{ $item['image'] }}" class="project-card-img w-100 h-100 object-fit-cover" alt="{{ $item['title'] }}">
                            <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy">
                                <span class="project-card-category badge bg-danger text-white fw-semibold text-uppercase text-xs mb-2 align-self-start shadow-sm" style="letter-spacing: 0.8px;">{{ $item['category'] }}</span>
                                <h4 class="project-card-title text-white fw-bold my-1" style="font-size: 1.2rem;">{{ $item['title'] }}</h4>
                                <div class="project-card-location text-white-50 small">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $item['location'] }}
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
