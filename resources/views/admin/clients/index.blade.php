@extends('layouts.admin')

@section('title', 'Kelola Klien - Admin Dashboard')
@section('page-title', 'Daftar Klien / Partner')

@section('admin-content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-people me-2 text-warning"></i>Klien & Partner Logo</h5>
        <a href="{{ route('admin.clients.create') }}" class="btn btn-navy text-white fw-semibold"><i class="bi bi-plus-lg me-1"></i> Tambah Partner</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light text-navy fw-bold text-xs uppercase">
                    <tr>
                        <th class="ps-3" style="width: 120px;">Logo</th>
                        <th>Perusahaan / Mitra</th>
                        <th>Website Link</th>
                        <th class="text-end pe-3" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td class="ps-3">
                                <div class="bg-light p-2 rounded text-center border" style="width: 80px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <img src="{{ asset('storage/' . $client->logo_path) }}" class="img-fluid object-fit-contain" style="max-height: 40px;" alt="{{ $client->name }}">
                                </div>
                            </td>
                            <td>
                                <strong class="text-navy">{{ $client->name }}</strong>
                            </td>
                            <td>
                                @if($client->website_url)
                                    <a href="{{ $client->website_url }}" target="_blank" class="text-decoration-none text-warning fw-semibold"><i class="bi bi-box-arrow-up-right me-1"></i> {{ $client->website_url }}</a>
                                @else
                                    <span class="text-muted text-xs">Tidak ada tautan</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group">
                                    <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-outline-warning btn-sm me-1 rounded"><i class="bi bi-pencil-square"></i> Edit</a>
                                    <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Belum ada partner/klien terdaftar. Silakan tambahkan partner baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $clients->links('pagination::bootstrap-5') }}
</div>
@endsection
