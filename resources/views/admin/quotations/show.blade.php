@extends('layouts.admin')

@section('title', 'Detail Quotation - Admin Dashboard')
@section('page-title', 'Detail Pengajuan Quotation')

@section('admin-content')
<div class="row g-4">
    <!-- Left Column: Details -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
            <h5 class="fw-bold text-navy border-bottom pb-2 mb-3">Informasi Utama Pengaju</h5>
            
            <div class="row g-3">
                <div class="col-sm-6">
                    <span class="text-muted text-xs d-block">NAMA PENGIRIM</span>
                    <strong class="text-navy fs-6">{{ $quotation->name }}</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted text-xs d-block">NAMA PERUSAHAAN</span>
                    <strong class="text-navy fs-6">{{ $quotation->company_name ?? '-' }}</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted text-xs d-block">EMAIL</span>
                    <strong class="text-navy fs-6"><i class="bi bi-envelope me-1"></i>{{ $quotation->email }}</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted text-xs d-block">NOMOR WHATSAPP</span>
                    <strong class="text-navy fs-6"><i class="bi bi-whatsapp me-1 text-success"></i>{{ $quotation->whatsapp }}</strong>
                </div>
            </div>

            <h5 class="fw-bold text-navy border-bottom pb-2 mb-3 mt-5">Informasi Rencana Proyek</h5>
            
            <div class="row g-3">
                <div class="col-sm-6">
                    <span class="text-muted text-xs d-block">JENIS PROYEK</span>
                    <strong class="text-navy fs-6">{{ $quotation->project_type }}</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted text-xs d-block">LOKASI RENCANA</span>
                    <strong class="text-navy fs-6"><i class="bi bi-geo-alt me-1"></i>{{ $quotation->location }}</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted text-xs d-block">PERKIRAAN LUAS BANGUNAN</span>
                    <strong class="text-navy fs-6">{{ $quotation->building_area ?? '-' }} m²</strong>
                </div>
                <div class="col-sm-6">
                    <span class="text-muted text-xs d-block">ESTIMASI RENCANA ANGGARAN</span>
                    <strong class="text-navy fs-6">{{ $quotation->budget ?? '-' }}</strong>
                </div>
            </div>

            @if($quotation->description)
                <h5 class="fw-bold text-navy border-bottom pb-2 mb-3 mt-5">Catatan Tambahan & Spesifikasi</h5>
                <div class="bg-light p-3 rounded border text-muted leading-relaxed">
                    {!! nl2br(e($quotation->description)) !!}
                </div>
            @endif
        </div>
    </div>

    <!-- Right Column: Document & Status -->
    <div class="col-lg-4">
        <!-- Document Download -->
        <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
            <h5 class="fw-bold text-navy mb-3"><i class="bi bi-paperclip text-warning me-1"></i>Dokumen Terlampir</h5>
            @if($quotation->file_path)
                <div class="bg-light p-3 rounded text-center border mb-3">
                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-1"></i>
                    <span class="d-block text-xs text-muted text-truncate mt-2" style="max-width: 100%;">{{ basename($quotation->file_path) }}</span>
                </div>
                <a href="{{ asset('storage/' . $quotation->file_path) }}" target="_blank" class="btn btn-navy text-white w-100 fw-semibold"><i class="bi bi-download me-1"></i> Download Dokumen</a>
            @else
                <div class="text-center py-3 text-muted text-sm border rounded">
                    Tidak melampirkan berkas gambar/DED.
                </div>
            @endif
        </div>

        <!-- Update Status -->
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
            <h5 class="fw-bold text-navy mb-3">Pembaruan Status</h5>
            
            <div class="mb-3">
                <span class="text-muted text-xs d-block mb-1">STATUS SAAT INI</span>
                @if($quotation->status == 'pending')
                    <span class="badge bg-warning text-dark text-xs uppercase py-2 px-3 fw-bold">Pending</span>
                @elseif($quotation->status == 'reviewed')
                    <span class="badge bg-info text-dark text-xs uppercase py-2 px-3 fw-bold">Reviewed</span>
                @elseif($quotation->status == 'approved')
                    <span class="badge bg-success text-white text-xs uppercase py-2 px-3 fw-bold">Approved</span>
                @else
                    <span class="badge bg-danger text-white text-xs uppercase py-2 px-3 fw-bold">Rejected</span>
                @endif
            </div>

            <form action="{{ route('admin.quotations.update-status', $quotation->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="status" class="form-label text-xs fw-semibold text-muted">UBAH STATUS MENJADI</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending" {{ $quotation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed" {{ $quotation->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="approved" {{ $quotation->status == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $quotation->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning text-dark w-100 fw-bold">Simpan Status</button>
            </form>
        </div>
    </div>
</div>
@endsection
