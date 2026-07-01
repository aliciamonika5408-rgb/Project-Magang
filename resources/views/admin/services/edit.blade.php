@extends('layouts.admin')

@section('title', 'Edit Layanan - Admin Dashboard')
@section('page-title', 'Edit Layanan: ' . $service->title)

@section('admin-content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3">
        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-pencil-fill me-2 text-warning"></i>Form Edit Layanan</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <!-- Title -->
                <div class="col-md-8">
                    <label for="title" class="form-label fw-semibold text-navy">Nama Layanan *</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: Konstruksi Gudang Bentang Lebar" required value="{{ old('title', $service->title) }}">
                </div>

                <!-- Icon -->
                <div class="col-md-4">
                    <label for="icon" class="form-label fw-semibold text-navy">Icon Class Bootstrap Icons *</label>
                    <input type="text" name="icon" id="icon" class="form-control" placeholder="Contoh: bi-building" required value="{{ old('icon', $service->icon) }}">
                    <span class="text-xs text-muted">Lihat kelas di <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a></span>
                </div>

                <!-- Short Description -->
                <div class="col-12">
                    <label for="description" class="form-label fw-semibold text-navy">Deskripsi Singkat *</label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Tulis deskripsi singkat untuk kartu beranda..." required>{{ old('description', $service->description) }}</textarea>
                </div>

                <!-- Content -->
                <div class="col-12">
                    <label for="content" class="form-label fw-semibold text-navy">Detail Isi Layanan / Cakupan Pekerjaan</label>
                    <textarea name="content" id="content" class="form-control" rows="6" placeholder="Masukkan rincian detail... HTML diperbolehkan.">{{ old('content', $service->content) }}</textarea>
                </div>

                <!-- Featured Image -->
                <div class="col-12">
                    <label for="image" class="form-label fw-semibold text-navy">Gambar Utama / Foto Banner</label>
                    @if($service->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $service->image) }}" class="rounded shadow-sm object-fit-cover d-block" style="width: 150px; height: 100px;" alt="{{ $service->title }}">
                            <span class="text-xs text-muted mt-1 d-block">Gambar Terpasang</span>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control">
                    <span class="text-xs text-muted">Format: JPG, PNG, WEBP. Ukuran file maksimal: 5MB (Kosongkan jika tidak ingin mengubah)</span>
                </div>

                <!-- Buttons -->
                <div class="col-12 mt-4 border-top pt-3 text-end">
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-navy text-white fw-bold px-4">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
