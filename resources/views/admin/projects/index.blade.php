@extends('layouts.admin')

@section('title', 'Kelola Proyek - Admin Dashboard')
@section('page-title', 'Daftar Portfolio Proyek')

@section('admin-content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-file-earmark-code me-2 text-warning"></i>Daftar Proyek</h5>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-navy text-white fw-semibold"><i class="bi bi-plus-lg me-1"></i> Tambah Proyek</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light text-navy fw-bold text-xs uppercase">
                    <tr>
                        <th class="ps-3" style="width: 80px;">Gambar</th>
                        <th>Proyek</th>
                        <th>Kategori</th>
                        <th>Lokasi & Tahun</th>
                        <th>Klien</th>
                        <th class="text-end pe-3" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projects as $project)
                        <tr>
                            <td class="ps-3">
                                <img src="{{ $project->image ? asset('storage/' . $project->image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=100&auto=format&fit=crop' }}" class="rounded object-fit-cover" style="width: 60px; height: 50px;" alt="{{ $project->title }}">
                            </td>
                            <td>
                                <strong class="text-navy d-block">{{ $project->title }}</strong>
                                <span class="text-xs text-muted">{{ $project->slug }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-navy border py-2 px-3 fw-semibold">{{ $project->category }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold text-navy">{{ $project->location }}</div>
                                <span class="text-xs text-muted">Tahun: {{ $project->year }}</span>
                            </td>
                            <td>{{ $project->client_name ?? '-' }}</td>
                            <td class="text-end pe-3">
                                <div class="btn-group">
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-outline-warning btn-sm me-1 rounded"><i class="bi bi-pencil-square"></i> Edit</a>
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus proyek ini? Seluruh gambar galeri juga akan dihapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada proyek terdaftar. Silakan tambahkan proyek baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $projects->links('pagination::bootstrap-5') }}
</div>
@endsection
