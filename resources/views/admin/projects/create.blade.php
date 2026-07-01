@extends('layouts.admin')

@section('title', 'Tambah Proyek - Admin Dashboard')
@section('page-title', 'Tambah Proyek Baru')

@section('admin-content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3">
        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-plus-circle-fill me-2 text-warning"></i>Form Proyek Baru</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <!-- Title -->
                <div class="col-md-6">
                    <label for="title" class="form-label fw-semibold text-navy">Nama Proyek *</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: Gudang Logistik Bentang Lebar WF" required value="{{ old('title') }}">
                </div>

                <!-- Category -->
                <div class="col-md-6">
                    <label for="category" class="form-label fw-semibold text-navy">Kategori Proyek *</label>
                    <select name="category" id="category" class="form-select" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option value="Gudang" {{ old('category') == 'Gudang' ? 'selected' : '' }}>Gudang</option>
                        <option value="Baja" {{ old('category') == 'Baja' ? 'selected' : '' }}>Konstruksi Baja</option>
                        <option value="Industri" {{ old('category') == 'Industri' ? 'selected' : '' }}>Bangunan Industri / Pabrik</option>
                        <option value="Erection" {{ old('category') == 'Erection' ? 'selected' : '' }}>Steel Erection</option>
                    </select>
                </div>

                <!-- Location -->
                <div class="col-md-6">
                    <label for="location" class="form-label fw-semibold text-navy">Lokasi Proyek *</label>
                    <input type="text" name="location" id="location" class="form-control" placeholder="Contoh: Bekasi, Jawa Barat" required value="{{ old('location') }}">
                </div>

                <!-- Year -->
                <div class="col-md-6">
                    <label for="year" class="form-label fw-semibold text-navy">Tahun Selesai *</label>
                    <input type="number" name="year" id="year" class="form-control" placeholder="Contoh: 2025" required min="2000" max="{{ date('Y') + 5 }}" value="{{ old('year', date('Y')) }}">
                </div>

                <!-- Client Name -->
                <div class="col-md-6">
                    <label for="client_name" class="form-label fw-semibold text-navy">Nama Klien / Perusahaan</label>
                    <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Contoh: PT Logistik Prima" value="{{ old('client_name') }}">
                </div>

                <!-- Budget -->
                <div class="col-md-6">
                    <label for="budget" class="form-label fw-semibold text-navy">Estimasi Anggaran (Teks / Angka)</label>
                    <input type="text" name="budget" id="budget" class="form-control" placeholder="Contoh: Rp 2.5 Milyar" value="{{ old('budget') }}">
                </div>

                <!-- Description -->
                <div class="col-12">
                    <label for="description" class="form-label fw-semibold text-navy">Deskripsi & Rincian Proyek *</label>
                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="Tuliskan spesifikasi pengerjaan, tantangan teknik, luas bentang, dsb..." required>{{ old('description') }}</textarea>
                </div>

                <!-- Primary Banner Image -->
                <div class="col-md-6">
                    <label for="image" class="form-label fw-semibold text-navy">Foto Utama Proyek *</label>
                    <input type="file" name="image" id="image" class="form-control" required>
                    <span class="text-xs text-muted">Foto utama yang akan tampil di halaman daftar portfolio. (Max: 5MB)</span>
                </div>

                <!-- Multiple Gallery Images -->
                <div class="col-md-6">
                    <label for="gallery" class="form-label fw-semibold text-navy">Upload Foto Galeri / Progres (Multifile)</label>
                    <input type="file" name="gallery[]" id="gallery" class="form-control" multiple>
                    <span class="text-xs text-muted">Dapat memilih lebih dari 1 file gambar. (Format: JPG, PNG. Max: 5MB per gambar)</span>
                </div>

                <!-- Buttons -->
                <div class="col-12 mt-4 border-top pt-3 text-end">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-navy text-white fw-bold px-4">Simpan Proyek</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
