@extends('layouts.admin')

@section('title', 'Edit Proyek - Admin Dashboard')
@section('page-title', 'Edit Proyek: ' . $project->title)

@section('admin-content')
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
                        <option value="Gudang" {{ old('category', $project->category) == 'Gudang' ? 'selected' : '' }}>Gudang</option>
                        <option value="Baja" {{ old('category', $project->category) == 'Baja' ? 'selected' : '' }}>Konstruksi Baja</option>
                        <option value="Industri" {{ old('category', $project->category) == 'Industri' ? 'selected' : '' }}>Bangunan Industri / Pabrik</option>
                        <option value="Erection" {{ old('category', $project->category) == 'Erection' ? 'selected' : '' }}>Steel Erection</option>
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
                <div class="col-md-6">
                    <label for="image" class="form-label fw-semibold text-navy">Foto Utama Proyek</label>
                    @if($project->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $project->image) }}" class="rounded shadow-sm object-fit-cover d-block" style="width: 150px; height: 100px;" alt="{{ $project->title }}">
                            <span class="text-xs text-muted mt-1 d-block">Foto Utama Terpasang</span>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control">
                    <span class="text-xs text-muted">Format: JPG, PNG. (Kosongkan jika tidak ingin merubah)</span>
                </div>

                <!-- Multiple Gallery Images upload -->
                <div class="col-md-6">
                    <label for="gallery" class="form-label fw-semibold text-navy">Tambah Foto Galeri / Progres (Multifile)</label>
                    <input type="file" name="gallery[]" id="gallery" class="form-control" multiple>
                    <span class="text-xs text-muted">Dapat menambahkan beberapa foto baru sekaligus.</span>
                </div>

                <!-- Buttons -->
                <div class="col-12 mt-4 border-top pt-3 text-end">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-navy text-white fw-bold px-4">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Gallery Management Section -->
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3">
        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-images me-2 text-warning"></i>Kelola Foto Galeri</h5>
    </div>
    <div class="card-body">
        <div class="row g-3" id="gallery-container">
            @forelse($project->images as $img)
                <div class="col-6 col-sm-4 col-md-3 col-lg-2" id="gallery-item-{{ $img->id }}">
                    <div class="border rounded shadow-sm overflow-hidden position-relative" style="height: 120px;">
                        <img src="{{ asset('storage/' . $img->image_path) }}" class="w-100 h-100 object-fit-cover" alt="Galeri">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow-sm" onclick="deleteGalleryItem({{ $img->id }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 text-muted">
                    Belum ada foto galeri terlampir untuk proyek ini.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function deleteGalleryItem(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus foto ini dari galeri proyek?')) return;
    
    // AJAX Request to destroy specific project image
    const xhr = new XMLHttpRequest();
    xhr.open('POST', `/admin/projects/gallery/${id}`);
    
    // Include CSRF and Method DELETE spoofing
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
    xhr.setRequestHeader('X-HTTP-Method-Override', 'DELETE');
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
    xhr.addEventListener('load', () => {
        if (xhr.status >= 200 && xhr.status < 300) {
            const res = JSON.parse(xhr.responseText);
            if (res.success) {
                const element = document.getElementById(`gallery-item-${id}`);
                if (element) {
                    element.remove();
                }
            } else {
                alert('Gagal menghapus gambar.');
            }
        } else {
            alert('Gagal menghapus gambar.');
        }
    });

    xhr.send();
}
</script>
@endsection
