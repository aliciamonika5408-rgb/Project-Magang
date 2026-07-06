@extends('layouts.admin')

@section('title', 'Edit Layanan Lainnya - Admin PT Multi Power Abadi')
@section('page-title', 'Edit Layanan Lainnya')

@section('admin-content')
<div class="mb-4">
    <a href="{{ route('admin.other-services.index') }}" class="text-decoration-none text-navy fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Layanan Lainnya
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('admin.other-services.update', $otherService->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold text-navy">Judul Layanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $otherService->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold text-navy">Deskripsi Singkat <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required>{{ old('description', $otherService->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="icon" class="form-label fw-bold text-navy">Icon Bootstrap <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi {{ $otherService->icon }}" id="icon-preview"></i></span>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" value="{{ old('icon', $otherService->icon) }}" required>
                        </div>
                        <small class="text-muted">Gunakan nama ikon Bootstrap Icons</small>
                        @error('icon')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-bold text-navy">Ganti Gambar Ilustrasi (Opsional)</label>
                        @if($otherService->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $otherService->image) }}" alt="Preview" class="img-thumbnail" style="height: 100px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.other-services.index') }}" class="btn btn-light px-4">Batal</a>
                <button type="submit" class="btn btn-warning px-4 fw-semibold text-navy">Simpan Perubahan</button>
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
