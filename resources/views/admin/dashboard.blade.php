@extends('layouts.admin')

@section('title', 'Admin Dashboard - PT Multi Power Abadi')
@section('page-title', 'Dashboard Ringkasan')

@section('admin-content')
<!-- Stats Widget Cards Grid -->
<div class="row g-4 mb-4">
    <!-- Services -->
    <div class="col-sm-6 col-lg-3">
        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase text-xs fw-semibold mb-1">Services Active</h6>
                    <span class="fs-2 fw-bold text-navy">{{ $totalServices }}</span>
                </div>
                <div class="bg-navy bg-opacity-10 text-navy rounded-3 p-3 fs-3">
                    <i class="bi bi-building"></i>
                </div>
            </div>
            <div class="card-footer bg-light border-0 py-2 text-center">
                <a href="{{ route('admin.services.index') }}" class="text-xs text-warning text-decoration-none fw-semibold">Kelola Layanan <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
    
    <!-- Projects -->
    <div class="col-sm-6 col-lg-3">
        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase text-xs fw-semibold mb-1">Total Proyek</h6>
                    <span class="fs-2 fw-bold text-navy">{{ $totalProjects }}</span>
                </div>
                <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-3 fs-3">
                    <i class="bi bi-file-earmark-code"></i>
                </div>
            </div>
            <div class="card-footer bg-light border-0 py-2 text-center">
                <a href="{{ route('admin.projects.index') }}" class="text-xs text-warning text-decoration-none fw-semibold">Kelola Portfolio <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Quotations -->
    <div class="col-sm-6 col-lg-3">
        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase text-xs fw-semibold mb-1">Quotation Baru</h6>
                    <span class="fs-2 fw-bold text-navy">{{ $pendingQuotations }}</span>
                    <span class="text-xs text-muted">/ {{ $totalQuotations }} total</span>
                </div>
                <div class="bg-success bg-opacity-10 text-success rounded-3 p-3 fs-3">
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                </div>
            </div>
            <div class="card-footer bg-light border-0 py-2 text-center">
                <a href="{{ route('admin.quotations.index') }}" class="text-xs text-warning text-decoration-none fw-semibold">Lihat Pengajuan <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    <!-- Messages -->
    <div class="col-sm-6 col-lg-3">
        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted text-uppercase text-xs fw-semibold mb-1">Pesan Unread</h6>
                    <span class="fs-2 fw-bold text-navy">{{ $unreadContacts }}</span>
                    <span class="text-xs text-muted">/ {{ $totalContacts }} total</span>
                </div>
                <div class="bg-info bg-opacity-10 text-info rounded-3 p-3 fs-3">
                    <i class="bi bi-chat-left-text"></i>
                </div>
            </div>
            <div class="card-footer bg-light border-0 py-2 text-center">
                <a href="{{ route('admin.contacts.index') }}" class="text-xs text-warning text-decoration-none fw-semibold">Buka Inbox <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Quotations -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-navy py-3">
                <h5 class="card-title text-white mb-0 fw-semibold"><i class="bi bi-file-earmark-spreadsheet-fill me-2 text-warning"></i>Pengajuan Quotation Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0 text-sm">
                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                            <tr>
                                <th class="ps-3">Nama</th>
                                <th>Proyek</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentQuotations as $quotation)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-semibold text-navy">{{ $quotation->name }}</div>
                                        <span class="text-xs text-muted">{{ $quotation->company_name ?? 'Personal' }}</span>
                                    </td>
                                    <td>{{ $quotation->project_type }}</td>
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
                                    <td class="text-end pe-3">
                                        <a href="{{ route('admin.quotations.show', $quotation->id) }}" class="btn btn-outline-primary btn-sm rounded-circle"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada pengajuan quotation masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-navy py-3">
                <h5 class="card-title text-white mb-0 fw-semibold"><i class="bi bi-chat-left-text-fill me-2 text-warning"></i>Pesan Kontak Masuk Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0 text-sm">
                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                            <tr>
                                <th class="ps-3">Pengirim</th>
                                <th>Subjek</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentContacts as $contact)
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-semibold text-navy">{{ $contact->name }}</div>
                                        <span class="text-xs text-muted">{{ $contact->email }}</span>
                                    </td>
                                    <td>{{ Str::limit($contact->subject, 30) }}</td>
                                    <td>
                                        @if(!$contact->is_read)
                                            <span class="badge bg-danger text-white text-xs uppercase px-2">Baru</span>
                                        @else
                                            <span class="badge bg-secondary text-white text-xs uppercase px-2">Dibaca</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-3">
                                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-outline-primary btn-sm rounded-circle"><i class="bi bi-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada pesan kontak masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
