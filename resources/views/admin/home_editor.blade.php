@extends('layouts.admin')

@section('title', 'Editor Halaman Home - Admin PT Multi Power Abadi')
@section('page-title', 'Editor Konten Halaman Utama (Home)')

@section('admin-content')
<div class="mb-4">
    <p class="text-muted mb-0">Kelola seluruh section yang tampil pada halaman **Home** website dalam satu panel editor terpadu.</p>
</div>

<!-- Home Sections Navigation Tabs -->
<ul class="nav nav-pills custom-admin-tabs mb-4 bg-white p-2 rounded-4 shadow-sm border" id="homeSectionsTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 {{ $activeTab == 'services' ? 'active' : '' }}" id="services-tab" data-bs-toggle="tab" data-bs-target="#tab-services" type="button" role="tab">
            <i class="bi bi-building me-1 text-danger"></i> Solusi Konstruksi Baja
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 {{ $activeTab == 'other-services' ? 'active' : '' }}" id="other-services-tab" data-bs-toggle="tab" data-bs-target="#tab-other-services" type="button" role="tab">
            <i class="bi bi-tools me-1 text-danger"></i> Layanan Lainnya
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 {{ $activeTab == 'projects' ? 'active' : '' }}" id="projects-tab" data-bs-toggle="tab" data-bs-target="#tab-projects" type="button" role="tab">
            <i class="bi bi-images me-1 text-danger"></i> Portfolio Proyek
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 {{ $activeTab == 'clients' ? 'active' : '' }}" id="clients-tab" data-bs-toggle="tab" data-bs-target="#tab-clients" type="button" role="tab">
            <i class="bi bi-people me-1 text-danger"></i> Klien Kami
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 {{ $activeTab == 'stats' ? 'active' : '' }}" id="stats-tab" data-bs-toggle="tab" data-bs-target="#tab-stats" type="button" role="tab">
            <i class="bi bi-sliders me-1 text-danger"></i> Statistik Perusahaan
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link text-navy fw-semibold px-3 py-2.5 rounded-3 {{ $activeTab == 'quotations' ? 'active' : '' }}" id="quotations-tab" data-bs-toggle="tab" data-bs-target="#tab-quotations" type="button" role="tab">
            <i class="bi bi-file-earmark-spreadsheet me-1 text-danger"></i> Request Quotation
        </button>
    </li>
</ul>

<!-- Tab Contents -->
<div class="tab-content" id="homeSectionsTabContent">

    <!-- ================= TAB 1: SOLUSI KONSTRUKSI BAJA ================= -->
    <div class="tab-pane fade {{ $activeTab == 'services' ? 'show active' : '' }}" id="tab-services" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-building me-2 text-danger"></i>Solusi Konstruksi Baja (Layanan Utama)</h5>
                <a href="{{ route('admin.services.create') }}" class="btn btn-danger btn-sm text-white fw-semibold">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Layanan Utama
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                            <tr>
                                <th class="ps-4" style="width: 80px;">Gambar</th>
                                <th>Layanan</th>
                                <th>Deskripsi Singkat</th>
                                <th>Icon</th>
                                <th class="text-end pe-4" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                                <tr>
                                    <td class="ps-4">
                                        <img src="{{ $service->image ? asset('storage/' . $service->image) : 'https://images.unsplash.com/photo-1581094288338-2314dddb7ecc?q=80&w=100&auto=format&fit=crop' }}" class="rounded object-fit-cover" style="width: 60px; height: 50px;" alt="{{ $service->title }}">
                                    </td>
                                    <td>
                                        <strong class="text-navy d-block">{{ $service->title }}</strong>
                                        <span class="text-xs text-muted">{{ $service->slug }}</span>
                                    </td>
                                    <td>{{ Str::limit($service->description, 90) }}</td>
                                    <td>
                                        <span class="badge bg-navy text-white py-2"><i class="bi {{ $service->icon }} me-1"></i> {{ $service->icon }}</span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-outline-warning btn-sm me-1 rounded"><i class="bi bi-pencil-square"></i> Edit</a>
                                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada layanan utama. Silakan tambahkan baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= TAB 2: LAYANAN LAINNYA ================= -->
    <div class="tab-pane fade {{ $activeTab == 'other-services' ? 'show active' : '' }}" id="tab-other-services" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-tools me-2 text-danger"></i>Layanan Lainnya (Dukungan & Interior)</h5>
                <a href="{{ route('admin.other-services.create') }}" class="btn btn-danger btn-sm text-white fw-semibold">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Layanan Lainnya
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                            <tr>
                                <th class="ps-4" style="width: 70px;">Icon</th>
                                <th>Judul Layanan</th>
                                <th>Deskripsi</th>
                                <th class="text-end pe-4" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($otherServices as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="bg-danger bg-opacity-10 text-danger rounded-3 d-inline-flex align-items-center justify-content-center" style="width: 42px; height: 42px; font-size: 1.2rem;">
                                            <i class="bi {{ $item->icon }}"></i>
                                        </div>
                                    </td>
                                    <td><strong class="text-navy">{{ $item->title }}</strong></td>
                                    <td><p class="text-muted text-sm mb-0">{{ Str::limit($item->description, 100) }}</p></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.other-services.edit', $item->id) }}" class="btn btn-outline-warning btn-sm me-1 rounded"><i class="bi bi-pencil-square"></i> Edit</a>
                                            <form action="{{ route('admin.other-services.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada layanan lainnya. Silakan tambahkan baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= TAB 3: PORTFOLIO PROYEK ================= -->
    <div class="tab-pane fade {{ $activeTab == 'projects' ? 'show active' : '' }}" id="tab-projects" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-images me-2 text-danger"></i>Portfolio Proyek (Dokumentasi Home)</h5>
                <a href="{{ route('admin.projects.create') }}" class="btn btn-danger btn-sm text-white fw-semibold">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Proyek Baru
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                            <tr>
                                <th class="ps-4" style="width: 80px;">Gambar</th>
                                <th>Proyek</th>
                                <th>Kategori</th>
                                <th>Lokasi & Tahun</th>
                                <th class="text-end pe-4" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td class="ps-4">
                                        <img src="{{ $project->image ? asset('storage/' . $project->image) : 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=100&auto=format&fit=crop' }}" class="rounded object-fit-cover" style="width: 60px; height: 50px;" alt="{{ $project->title }}">
                                    </td>
                                    <td>
                                        <strong class="text-navy d-block">{{ $project->title }}</strong>
                                        <span class="text-xs text-muted">{{ $project->slug }}</span>
                                    </td>
                                    <td><span class="badge bg-light text-navy border py-2 px-3 fw-semibold">{{ $project->category }}</span></td>
                                    <td>{{ $project->location }} ({{ $project->year }})</td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.projects.edit', $project->id) }}" class="btn btn-outline-warning btn-sm me-1 rounded"><i class="bi bi-pencil-square"></i> Edit</a>
                                            <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada proyek terdaftar. Silakan tambahkan proyek baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= TAB 4: KLIEN KAMI ================= -->
    <div class="tab-pane fade {{ $activeTab == 'clients' ? 'show active' : '' }}" id="tab-clients" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-people me-2 text-danger"></i>Klien Kami (Logo Mitra)</h5>
                <a href="{{ route('admin.clients.create') }}" class="btn btn-danger btn-sm text-white fw-semibold">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Klien Baru
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                            <tr>
                                <th class="ps-4" style="width: 120px;">Logo</th>
                                <th>Perusahaan / Mitra</th>
                                <th>Website Link</th>
                                <th class="text-end pe-4" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                <tr>
                                    <td class="ps-4">
                                        <div class="bg-light p-2 rounded text-center border" style="width: 80px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                            <img src="{{ asset('storage/' . $client->logo_path) }}" class="img-fluid object-fit-contain" style="max-height: 40px;" alt="{{ $client->name }}">
                                        </div>
                                    </td>
                                    <td><strong class="text-navy">{{ $client->name }}</strong></td>
                                    <td>
                                        @if($client->website_url)
                                            <a href="{{ $client->website_url }}" target="_blank" class="text-decoration-none text-danger small"><i class="bi bi-box-arrow-up-right me-1"></i> {{ $client->website_url }}</a>
                                        @else
                                            <span class="text-muted text-xs">Tidak ada tautan</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.clients.edit', $client->id) }}" class="btn btn-outline-warning btn-sm me-1 rounded"><i class="bi bi-pencil-square"></i> Edit</a>
                                            <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i> Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada klien terdaftar. Silakan tambahkan klien baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= TAB 5: STATISTIK PERUSAHAAN ================= -->
    <div class="tab-pane fade {{ $activeTab == 'stats' ? 'show active' : '' }}" id="tab-stats" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-sliders me-2 text-danger"></i>Statistik & Angka Perusahaan</h5>
            </div>
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border bg-light p-3">
                                <label for="years_experience" class="form-label fw-bold text-navy">Tahun Pengalaman</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg fw-bold text-navy" id="years_experience" name="years_experience" value="{{ old('years_experience', $stats['years_experience'] ?? '15') }}" required>
                                    <span class="input-group-text bg-white fw-bold">Tahun</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border bg-light p-3">
                                <label for="projects_completed" class="form-label fw-bold text-navy">Proyek Selesai</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg fw-bold text-navy" id="projects_completed" name="projects_completed" value="{{ old('projects_completed', $stats['projects_completed'] ?? '150') }}" required>
                                    <span class="input-group-text bg-white fw-bold">Proyek</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border bg-light p-3">
                                <label for="experts_count" class="form-label fw-bold text-navy">Tenaga Ahli</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg fw-bold text-navy" id="experts_count" name="experts_count" value="{{ old('experts_count', $stats['experts_count'] ?? '50') }}" required>
                                    <span class="input-group-text bg-white fw-bold">Orang</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border bg-light p-3">
                                <label for="work_accidents" class="form-label fw-bold text-navy">Kecelakaan Kerja (K3 / Zero Accident)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg fw-bold text-navy" id="work_accidents" name="work_accidents" value="{{ old('work_accidents', $stats['work_accidents'] ?? '0') }}" required>
                                    <span class="input-group-text bg-white fw-bold">Kasus</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-danger px-5 py-2.5 fw-bold text-white shadow-sm">
                            <i class="bi bi-check-circle-fill me-2"></i> Simpan Statistik
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ================= TAB 6: REQUEST QUOTATION ================= -->
    <div class="tab-pane fade {{ $activeTab == 'quotations' ? 'show active' : '' }}" id="tab-quotations" role="tabpanel">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white py-3">
                <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-file-earmark-spreadsheet me-2 text-danger"></i>Daftar Pengajuan Request Quotation (Penawaran)</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0 text-sm">
                        <thead class="table-light text-navy fw-bold text-xs uppercase">
                            <tr>
                                <th class="ps-4">Nama / Perusahaan</th>
                                <th>Kontak Info</th>
                                <th>Jenis Proyek</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($quotations as $quotation)
                                <tr>
                                    <td class="ps-4">
                                        <strong class="text-navy d-block">{{ $quotation->name }}</strong>
                                        <span class="text-xs text-muted">{{ $quotation->company_name ?? 'Personal' }}</span>
                                    </td>
                                    <td>
                                        <div><i class="bi bi-envelope me-1 text-muted"></i>{{ $quotation->email }}</div>
                                        <small class="text-muted"><i class="bi bi-whatsapp me-1 text-success"></i>{{ $quotation->phone }}</small>
                                    </td>
                                    <td>{{ $quotation->project_type }}</td>
                                    <td>
                                        <form action="{{ route('admin.quotations.update-status', $quotation->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm border-0 bg-light fw-bold text-xs" onchange="this.form.submit()">
                                                <option value="pending" {{ $quotation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="reviewed" {{ $quotation->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                                <option value="approved" {{ $quotation->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ $quotation->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.quotations.show', $quotation->id) }}" class="btn btn-outline-primary btn-sm rounded-circle me-1"><i class="bi bi-eye"></i></a>
                                            <form action="{{ route('admin.quotations.destroy', $quotation->id) }}" method="POST" onsubmit="return confirm('Yakin hapus quotation ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada pengajuan quotation.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($quotations->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $quotations->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

@section('styles')
<style>
    .custom-admin-tabs .nav-link {
        color: #1e293b;
        background: transparent;
        transition: all 0.3s ease;
    }
    .custom-admin-tabs .nav-link.active {
        background-color: #0f172a !important;
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25);
    }
    .custom-admin-tabs .nav-link.active i {
        color: #ef4444 !important;
    }
</style>
@endsection
@endsection
