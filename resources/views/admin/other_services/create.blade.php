@extends('layouts.admin')

@section('title', 'Tambah Layanan Lainnya - Admin PT Multi Power Abadi')
@section('page-title', 'Tambah Layanan Lainnya Baru')

@section('admin-content')
<div class="mb-4">
    <a href="{{ route('admin.other-services.index') }}" class="text-decoration-none text-navy fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Layanan Lainnya
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('admin.other-services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold text-navy">Judul Layanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="Contoh: Konstruksi Renovasi Residensial & Komersial">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold text-navy">Deskripsi Singkat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required placeholder="Jelaskan cakupan layanan ini secara padat dan jelas">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="icon" class="form-label fw-bold text-navy">Icon Bootstrap <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-tools" id="icon-preview"></i></span>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', 'bi-tools') }}" required placeholder="bi-house-gear-fill">
                        </div>
                        <small class="text-muted">Gunakan nama ikon Bootstrap Icons, contoh: <code>bi-house-gear-fill</code>, <code>bi-vector-pen</code>, <code>bi-lightning-charge-fill</code>, <code>bi-hammer</code></small>
                        @error('icon')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold text-navy">Gambar Ilustrasi (Opsional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, WEBP (Maks 5MB)</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.other-services.index') }}" class="btn btn-light px-4">Batal</a>
                <button type="submit" class="btn btn-warning px-4 fw-semibold text-navy">Simpan Layanan</button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('icon').addEventListener('input', function() {
        const preview = document.getElementById('icon-preview');
        preview.className = 'bi ' + this.value;
    });
</script>
@endsection
@endsection
