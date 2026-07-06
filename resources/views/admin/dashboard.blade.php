@extends('layouts.admin')

@section('title', 'Admin Dashboard - PT Multi Power Abadi')
@section('page-title', 'Dashboard Ringkasan Administrator')

@section('admin-content')
<!-- Quick Actions Banner -->
<div class="card border-0 shadow-sm rounded-4 mb-4 bg-navy text-white overflow-hidden position-relative">
    <div class="card-body p-4 p-md-5 position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-warning text-dark text-xs uppercase px-3 py-2 rounded-pill mb-2 fw-bold">Navigasi Terintegrasi</span>
                <h2 class="fw-bold text-white mb-2">Selamat Datang di Panel Admin PT. Multi Power Abadi</h2>
                <p class="text-white-50 mb-4 mb-lg-0" style="max-width: 600px;">
                    Kelola seluruh halaman website (Home, Services, Projects, dan Contact) dari satu dashboard terpadu yang sederhana dan mudah digunakan.
                </p>
            </div>
            <div class="col-lg-5 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.home-editor') }}" class="btn btn-warning btn-md fw-bold text-navy shadow-sm">
                        <i class="bi bi-house-door-fill me-1"></i> Edit Halaman Home
                    </a>
                    <a href="{{ route('admin.services.index') }}" class="btn btn-outline-light btn-md fw-semibold shadow-sm">
                        <i class="bi bi-building me-1"></i> Services
                    </a>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-light btn-md fw-semibold shadow-sm">
                        <i class="bi bi-images me-1"></i> Projects
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main 4 Navigation Modules Cards Grid -->
<div class="row g-4 mb-4">
    <!-- Home Editor Module -->
    <div class="col-md-6 col-lg-3">
        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100 rounded-4">
            <div class="card-body p-4 text-center">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-house-door-fill fs-3"></i>
                </div>
                <h5 class="fw-bold text-navy mb-1">Halaman Home</h5>
                <p class="text-muted text-xs mb-3">Solusi Baja, Layanan Lainnya, Portfolio, Klien, & Statistik</p>
            </div>
            <div class="card-footer bg-light border-0 py-3 text-center rounded-bottom-4">
                <a href="{{ route('admin.home-editor') }}" class="btn btn-sm btn-danger w-100 fw-semibold text-white">Edit Konten Home <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <!-- Services Module -->
    <div class="col-md-6 col-lg-3">
        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100 rounded-4">
            <div class="card-body p-4 text-center">
                <div class="bg-navy bg-opacity-10 text-navy rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-building fs-3"></i>
                </div>
                <h5 class="fw-bold text-navy mb-1">Halaman Services</h5>
                <span class="fs-4 fw-bold text-navy d-block mb-1">{{ $totalServices }} Layanan</span>
                <p class="text-muted text-xs mb-3">Kelola rincian & detail halaman Services</p>
            </div>
            <div class="card-footer bg-light border-0 py-3 text-center rounded-bottom-4">
                <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-navy w-100 fw-semibold text-white">Kelola Services <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <!-- Projects Module -->
    <div class="col-md-6 col-lg-3">
        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100 rounded-4">
            <div class="card-body p-4 text-center">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-images fs-3"></i>
                </div>
                <h5 class="fw-bold text-navy mb-1">Halaman Projects</h5>
                <span class="fs-4 fw-bold text-navy d-block mb-1">{{ $totalProjects }} Proyek</span>
                <p class="text-muted text-xs mb-3">Kelola dokumentasi proyek & foto galeri</p>
            </div>
            <div class="card-footer bg-light border-0 py-3 text-center rounded-bottom-4">
                <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-warning w-100 fw-bold text-navy">Kelola Projects <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>

    <!-- Contact Module -->
    <div class="col-md-6 col-lg-3">
        <div class="card admin-stat-card border-0 bg-white shadow-sm h-100 rounded-4">
            <div class="card-body p-4 text-center">
                <div class="bg-info bg-opacity-10 text-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-envelope-paper-fill fs-3"></i>
                </div>
                <h5 class="fw-bold text-navy mb-1">Halaman Contact</h5>
                <span class="fs-4 fw-bold text-navy d-block mb-1">{{ $unreadContacts }} Pesan Baru</span>
                <p class="text-muted text-xs mb-3">Kotak masuk pertanyaan & pesan kontak</p>
            </div>
            <div class="card-footer bg-light border-0 py-3 text-center rounded-bottom-4">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-info w-100 fw-semibold text-white">Buka Contact Inbox <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Quotations -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-navy py-3 d-flex justify-content-between align-items-center rounded-top-4">
                <h5 class="card-title text-white mb-0 fw-semibold fs-6"><i class="bi bi-file-earmark-spreadsheet-fill me-2 text-warning"></i>Request Quotation Terbaru</h5>
                <a href="{{ route('admin.home-editor', ['tab' => 'quotations']) }}" class="btn btn-xs btn-outline-light">Kelola di Home Editor</a>
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
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-navy py-3 d-flex justify-content-between align-items-center rounded-top-4">
                <h5 class="card-title text-white mb-0 fw-semibold fs-6"><i class="bi bi-chat-left-text-fill me-2 text-warning"></i>Pesan Masuk Contact</h5>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-xs btn-outline-light">Lihat Semua</a>
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
