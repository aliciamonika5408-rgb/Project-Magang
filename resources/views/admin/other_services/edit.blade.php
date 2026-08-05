@extends('layouts.admin')

@section('title', 'Edit Layanan Lainnya - Admin PT Multi Power Abadi')
@section('page-title', 'Edit Layanan Lainnya')

@section('admin-content')
<div class="mb-4">
    <a href="{{ route('admin.home-editor', ['tab' => 'other-services']) }}" class="btn btn-outline-secondary fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Home Editor
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('admin.other-services.update', $otherService->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-12">
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
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.home-editor', ['tab' => 'other-services']) }}" class="btn btn-light px-4">Batal</a>
                <button type="submit" class="btn btn-warning px-4 fw-semibold text-navy">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
