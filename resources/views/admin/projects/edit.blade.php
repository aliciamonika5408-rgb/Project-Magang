@extends('layouts.admin')

@section('title', 'Edit Proyek - Admin Dashboard')
@section('page-title', 'Edit Proyek: ' . $project->title)

@section('admin-content')
<div class="mb-4">
    <a href="{{ route('admin.home-editor', ['tab' => 'projects']) }}" class="btn btn-outline-secondary fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Home Editor
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-pencil-fill me-2 text-warning"></i>Form Edit Proyek</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <!-- Title -->
                <div class="col-md-6">
                    <label for="title" class="form-label fw-semibold text-navy">Nama Proyek *</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: Gudang Logistik WF" required value="{{ old('title', $project->title) }}">
                </div>

                <!-- Category -->
                <div class="col-md-6">
                    <label for="category" class="form-label fw-semibold text-navy">Kategori Proyek *</label>
                    <select name="category" id="category" class="form-select" required>
                        <option value="Mezzanine" {{ old('category', $project->category) == 'Mezzanine' ? 'selected' : '' }}>Mezzanine</option>
                        <option value="Gedung" {{ old('category', $project->category) == 'Gedung' ? 'selected' : '' }}>Gedung</option>
                    </select>
                </div>

                <!-- Location -->
                <div class="col-md-6">
                    <label for="location" class="form-label fw-semibold text-navy">Lokasi Proyek *</label>
                    <input type="text" name="location" id="location" class="form-control" placeholder="Contoh: Bekasi, Jawa Barat" required value="{{ old('location', $project->location) }}">
                </div>

                <!-- Year -->
                <div class="col-md-6">
                    <label for="year" class="form-label fw-semibold text-navy">Tahun Selesai *</label>
                    <input type="number" name="year" id="year" class="form-control" placeholder="Contoh: 2025" required min="2000" max="{{ date('Y') + 5 }}" value="{{ old('year', $project->year) }}">
                </div>

                <!-- Client Name -->
                <div class="col-md-6">
                    <label for="client_name" class="form-label fw-semibold text-navy">Nama Klien / Perusahaan</label>
                    <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Contoh: PT Logistik Prima" value="{{ old('client_name', $project->client_name) }}">
                </div>

                <!-- Budget -->
                <div class="col-md-6">
                    <label for="budget" class="form-label fw-semibold text-navy">Estimasi Anggaran</label>
                    <input type="text" name="budget" id="budget" class="form-control" placeholder="Contoh: Rp 2.5 Milyar" value="{{ old('budget', $project->budget) }}">
                </div>

                <!-- Description -->
                <div class="col-12">
                    <label for="description" class="form-label fw-semibold text-navy">Deskripsi & Rincian Proyek *</label>
                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="..." required>{{ old('description', $project->description) }}</textarea>
                </div>

                <!-- Primary Banner Image -->
                <div class="col-md-12">
                    <label for="image" class="form-label fw-semibold text-navy">Foto Utama Proyek</label>
                    @if($project->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $project->image) }}" class="rounded shadow-sm object-fit-cover d-block" style="width: 150px; height: 100px;" alt="{{ $project->title }}">
                            <span class="text-xs text-muted mt-1 d-block">Foto Utama Terpasang</span>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control">
                    <span class="text-xs text-muted">Format: JPG, PNG. Max: 5MB (Kosongkan jika tidak ingin merubah)</span>
                </div>

                <!-- Buttons -->
                <div class="col-12 mt-4 border-top pt-3 text-end">
                    <a href="{{ route('admin.home-editor', ['tab' => 'projects']) }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-navy text-white fw-bold px-4">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
