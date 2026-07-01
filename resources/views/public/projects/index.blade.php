@extends('layouts.public')

@section('title', 'Portfolio Proyek Konstruksi & Struktur Baja - PT Multi Power Abadi')

@section('content')
<!-- Page Header -->
<div class="bg-navy text-white py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F2D5C 0%, #0a1f40 100%);">
    <div class="container py-4 text-center">
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
                    <div class="project-card border rounded-4 overflow-hidden position-relative shadow-sm" style="height: 290px;">
                        <img src="{{ $project->image ? asset('storage/' . $project->image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=600&auto=format&fit=crop' }}" class="w-100 h-100 object-fit-cover transition-zoom" alt="{{ $project->title }}">
                        <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end bg-gradient-navy" style="background: linear-gradient(to top, rgba(15,45,92,0.95) 0%, rgba(15,45,92,0.4) 60%, transparent 100%);">
                            <span class="project-card-category text-warning fw-semibold text-uppercase text-xs">{{ $project->category }}</span>
                            <h4 class="project-card-title text-white fw-bold my-1">{{ $project->title }}</h4>
                            <div class="project-card-location text-white-50 text-xs mb-3">
                                <i class="bi bi-geo-alt-fill me-1"></i> {{ $project->location }}, {{ $project->year }}
                            </div>
                            <a href="{{ route('public.projects.detail', $project->slug) }}" class="btn btn-warning btn-sm align-self-start fw-semibold shadow">Detail Proyek</a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback Projects -->
                @php
                    $staticProjects = [
                        ['title' => 'Gudang Logistik Modern', 'category' => 'Gudang', 'location' => 'Bekasi, Jawa Barat', 'year' => 2025, 'img' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Hangar Pemeliharaan Pesawat', 'category' => 'Konstruksi Baja', 'location' => 'Tangerang, Banten', 'year' => 2024, 'img' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?q=80&w=600&auto=format&fit=crop'],
                        ['title' => 'Pabrik Pengolahan Sawit', 'category' => 'Bangunan Industri', 'location' => 'Pekanbaru, Riau', 'year' => 2023, 'img' => 'https://images.unsplash.com/photo-1516937941344-00b4e0337589?q=80&w=600&auto=format&fit=crop']
                    ];
                @endphp
                @foreach($staticProjects as $item)
                    <div class="col-md-6 col-lg-4 reveal">
                        <div class="project-card border rounded-4 overflow-hidden position-relative shadow-sm" style="height: 290px;">
                            <img src="{{ $item['img'] }}" class="w-100 h-100 object-fit-cover" alt="{{ $item['title'] }}">
                            <div class="project-card-overlay p-4 position-absolute bottom-0 start-0 w-100 h-100 d-flex flex-column justify-content-end" style="background: linear-gradient(to top, rgba(15,45,92,0.95) 0%, rgba(15,45,92,0.4) 60%, transparent 100%);">
                                <span class="project-card-category text-warning fw-semibold text-uppercase text-xs">{{ $item['category'] }}</span>
                                <h4 class="project-card-title text-white fw-bold my-1">{{ $item['title'] }}</h4>
                                <div class="project-card-location text-white-50 text-xs mb-3">
                                    <i class="bi bi-geo-alt-fill me-1"></i> {{ $item['location'] }}, {{ $item['year'] }}
                                </div>
                                <a href="#" class="btn btn-warning btn-sm align-self-start fw-semibold shadow">Detail Proyek</a>
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
