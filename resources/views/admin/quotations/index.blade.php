@extends('layouts.admin')

@section('title', 'Kelola Quotation - Admin Dashboard')
@section('page-title', 'Pengajuan Penawaran Proyek (Quotation)')

@section('admin-content')
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body py-3 d-flex justify-content-between align-items-center">
        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-file-earmark-spreadsheet-fill text-warning me-2"></i>Filter Status</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.quotations.index', ['status' => 'all']) }}" class="btn btn-sm btn-outline-navy {{ request('status') == 'all' || !request('status') ? 'active' : '' }}">Semua</a>
            <a href="{{ route('admin.quotations.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-warning {{ request('status') == 'pending' ? 'active' : '' }}">Pending</a>
            <a href="{{ route('admin.quotations.index', ['status' => 'reviewed']) }}" class="btn btn-sm btn-outline-info {{ request('status') == 'reviewed' ? 'active' : '' }}">Reviewed</a>
            <a href="{{ route('admin.quotations.index', ['status' => 'approved']) }}" class="btn btn-sm btn-outline-success {{ request('status') == 'approved' ? 'active' : '' }}">Approved</a>
            <a href="{{ route('admin.quotations.index', ['status' => 'rejected']) }}" class="btn btn-sm btn-outline-danger {{ request('status') == 'rejected' ? 'active' : '' }}">Rejected</a>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light text-navy fw-bold text-xs uppercase">
                    <tr>
                        <th class="ps-3">Pengirim</th>
                        <th>WhatsApp / Email</th>
                        <th>Jenis Proyek</th>
                        <th>Lokasi & Luas</th>
                        <th>Status</th>
                        <th>Tanggal Pengajuan</th>
                        <th class="text-end pe-3" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotations as $quotation)
                        <tr>
                            <td class="ps-3">
                                <strong class="text-navy d-block">{{ $quotation->name }}</strong>
                                <span class="text-xs text-muted">{{ $quotation->company_name ?? 'Personal' }}</span>
                            </td>
                            <td>
                                <div class="text-navy fw-semibold"><i class="bi bi-whatsapp text-success me-1"></i>{{ $quotation->whatsapp }}</div>
                                <span class="text-xs text-muted">{{ $quotation->email }}</span>
                            </td>
                            <td>{{ $quotation->project_type }}</td>
                            <td>
                                <div class="text-navy fw-semibold">{{ $quotation->location }}</div>
                                <span class="text-xs text-muted">{{ $quotation->building_area ?? '-' }} m²</span>
                            </td>
                            <td>
                                @if($quotation->status == 'pending')
                                    <span class="badge bg-warning text-dark text-xs uppercase px-2">Pending</span>
                                @elseif($quotation->status == 'reviewed')
                                    <span class="badge bg-info text-dark text-xs uppercase px-2">Reviewed</span>
                                @elseif($quotation->status == 'approved')
                                    <span class="badge bg-success text-white text-xs uppercase px-2">Approved</span>
                                @else
                                    <span class="badge bg-danger text-white text-xs uppercase px-2">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $quotation->created_at->format('d M Y, H:i') }} WIB</td>
                            <td class="text-end pe-3">
                                <div class="btn-group">
                                    <a href="{{ route('admin.quotations.show', $quotation->id) }}" class="btn btn-outline-primary btn-sm me-1 rounded"><i class="bi bi-eye"></i> Detail</a>
                                    <form action="{{ route('admin.quotations.destroy', $quotation->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data quotation ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Tidak ditemukan pengajuan quotation untuk filter ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $quotations->links('pagination::bootstrap-5') }}
</div>
@endsection
