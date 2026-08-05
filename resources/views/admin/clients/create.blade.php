@extends('layouts.admin')

@section('title', 'Tambah Partner - Admin Dashboard')
@section('page-title', 'Tambah Partner Baru')

@section('admin-content')
<div class="mb-4">
    <a href="{{ route('admin.home-editor', ['tab' => 'clients']) }}" class="btn btn-outline-secondary fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Home Editor
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3">
        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-plus-circle-fill me-2 text-warning"></i>Form Partner Baru</h5>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <!-- Name -->
                <div class="col-12">
                    <label for="name" class="form-label fw-semibold text-navy">Nama Perusahaan / Partner *</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: PT Logistik Indonesia" required value="{{ old('name') }}">
                </div>

                <!-- Brand Logo Image -->
                <div class="col-12">
                    <label for="logo" class="form-label fw-semibold text-navy">File Logo Perusahaan *</label>
                    <input type="file" name="logo" id="logo" class="form-control" required>
                    <span class="text-xs text-muted">Format: JPG, PNG, SVG, WEBP. Maksimal ukuran file: 5MB</span>
                </div>

                <!-- Buttons -->
                <div class="col-12 mt-4 border-top pt-3 text-end">
                    <a href="{{ route('admin.home-editor', ['tab' => 'clients']) }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-navy text-white fw-bold px-4">Simpan Partner</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
