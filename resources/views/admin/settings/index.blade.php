@extends('layouts.admin')

@section('title', 'Kelola Statistik Perusahaan - Admin PT Multi Power Abadi')
@section('page-title', 'Kelola Statistik & Angka Perusahaan')

@section('admin-content')
<div class="mb-4">
    <p class="text-muted">Ubah nilai angka statistik perusahaan yang tampil pada halaman depan website (Tahun Pengalaman, Proyek Selesai, Tenaga Ahli, dan Kecelakaan Kerja).</p>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf

            <div class="row g-4">
                <!-- Tahun Pengalaman -->
                <div class="col-md-6">
                    <div class="card border bg-light h-100 p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-warning bg-opacity-20 text-warning p-3 rounded-3 fs-3">
                                <i class="bi bi-calendar-check-fill"></i>
                            </div>
                            <div>
                                <label for="years_experience" class="form-label fw-bold text-navy mb-0">Tahun Pengalaman</label>
                                <small class="text-muted d-block">Lama perusahaan beroperasi di bidang konstruksi</small>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg fw-bold text-navy" id="years_experience" name="years_experience" value="{{ old('years_experience', $settings['years_experience'] ?? '15') }}" required placeholder="Contoh: 15">
                            <span class="input-group-text bg-white fw-bold">Tahun</span>
                        </div>
                    </div>
                </div>

                <!-- Proyek Selesai -->
                <div class="col-md-6">
                    <div class="card border bg-light h-100 p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-navy bg-opacity-10 text-navy p-3 rounded-3 fs-3">
                                <i class="bi bi-building-check"></i>
                            </div>
                            <div>
                                <label for="projects_completed" class="form-label fw-bold text-navy mb-0">Proyek Selesai</label>
                                <small class="text-muted d-block">Jumlah proyek konstruksi baja & gedung yang telah dirampungkan</small>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg fw-bold text-navy" id="projects_completed" name="projects_completed" value="{{ old('projects_completed', $settings['projects_completed'] ?? '150') }}" required placeholder="Contoh: 150">
                            <span class="input-group-text bg-white fw-bold">Proyek</span>
                        </div>
                    </div>
                </div>

                <!-- Tenaga Ahli -->
                <div class="col-md-6">
                    <div class="card border bg-light h-100 p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 fs-3">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <label for="experts_count" class="form-label fw-bold text-navy mb-0">Tenaga Ahli</label>
                                <small class="text-muted d-block">Jumlah engineer, arsitek & pengawas profesional</small>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg fw-bold text-navy" id="experts_count" name="experts_count" value="{{ old('experts_count', $settings['experts_count'] ?? '50') }}" required placeholder="Contoh: 50">
                            <span class="input-group-text bg-white fw-bold">Orang</span>
                        </div>
                    </div>
                </div>

                <!-- Kecelakaan Kerja -->
                <div class="col-md-6">
                    <div class="card border bg-light h-100 p-3">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 fs-3">
                                <i class="bi bi-shield-fill-check"></i>
                            </div>
                            <div>
                                <label for="work_accidents" class="form-label fw-bold text-navy mb-0">Kecelakaan Kerja (K3)</label>
                                <small class="text-muted d-block">Metrik keselamatan kerja K3 (Zero Accident)</small>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg fw-bold text-navy" id="work_accidents" name="work_accidents" value="{{ old('work_accidents', $settings['work_accidents'] ?? '0') }}" required placeholder="Contoh: 0">
                            <span class="input-group-text bg-white fw-bold">Kasus</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-warning px-5 py-2.5 fw-bold text-navy shadow-sm">
                    <i class="bi bi-check-circle-fill me-2"></i> Simpan Perubahan Statistik
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
