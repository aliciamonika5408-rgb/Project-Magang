@extends('layouts.admin')

@section('title', 'Kelola Layanan Lainnya - Admin PT Multi Power Abadi')
@section('page-title', 'Kelola Layanan Lainnya (Dukungan)')

@section('admin-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Daftar layanan konstruksi dukungan & interior yang ditampilkan pada bagian 'Layanan Lainnya'.</p>
    <a href="{{ route('admin.other-services.create') }}" class="btn btn-warning fw-semibold shadow-sm text-navy">
        <i class="bi bi-plus-lg me-1"></i> Tambah Layanan Lainnya
    </a>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light text-navy fw-bold text-xs uppercase">
                    <tr>
                        <th class="ps-4">Icon</th>
                        <th>Judul Layanan</th>
                        <th>Deskripsi</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($otherServices as $service)
                        <tr>
                            <td class="ps-4">
                                <div class="bg-danger bg-opacity-10 text-danger rounded-3 d-inline-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 1.25rem;">
                                    <i class="bi {{ $service->icon }}"></i>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-navy fs-6">{{ $service->title }}</div>
                            </td>
                            <td style="max-width: 400px;">
                                <p class="text-muted text-sm mb-0">{{ Str::limit($service->description, 100) }}</p>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('admin.other-services.edit', $service->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.other-services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus layanan ini?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Belum ada data Layanan Lainnya. Klik tombol di atas untuk menambah data baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($otherServices->hasPages())
        <div class="card-footer bg-white border-0 py-3">
            {{ $otherServices->links() }}
        </div>
    @endif
</div>
@endsection
