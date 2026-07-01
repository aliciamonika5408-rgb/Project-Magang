@extends('layouts.admin')

@section('title', 'Kelola Layanan - Admin Dashboard')
@section('page-title', 'Daftar Layanan Konstruksi')

@section('admin-content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-building me-2 text-warning"></i>Daftar Layanan</h5>
        <a href="{{ route('admin.services.create') }}" class="btn btn-navy text-white fw-semibold"><i class="bi bi-plus-lg me-1"></i> Tambah Layanan</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light text-navy fw-bold text-xs uppercase">
                    <tr>
                        <th class="ps-3" style="width: 80px;">Gambar</th>
                        <th>Layanan</th>
                        <th>Deskripsi Singkat</th>
                        <th>Icon Class</th>
                        <th class="text-end pe-3" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td class="ps-3">
                                <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://images.unsplash.com/photo-1581094288338-2314dddb7ecc?q=80&w=100&auto=format&fit=crop' }}" class="rounded object-fit-cover" style="width: 60px; height: 50px;" alt="{{ $service->title }}">
                            </td>
                            <td>
                                <strong class="text-navy d-block">{{ $service->title }}</strong>
                                <span class="text-xs text-muted">{{ $service->slug }}</span>
                            </td>
                            <td>{{ Str::limit($service->description, 80) }}</td>
                            <td>
                                <span class="badge bg-navy text-white py-2"><i class="bi {{ $service->icon }} me-1"></i> {{ $service->icon }}</span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group">
                                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-outline-warning btn-sm me-1 rounded"><i class="bi bi-pencil-square"></i> Edit</a>
                                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada layanan terdaftar. Silakan tambahkan layanan baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $services->links('pagination::bootstrap-5') }}
</div>
@endsection
