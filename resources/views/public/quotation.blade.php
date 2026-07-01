@extends('layouts.public')

@section('title', 'Request Quotation Penawaran Proyek - PT Multi Power Abadi')

@section('content')
<!-- Page Header -->
<div class="bg-navy text-white py-5 position-relative overflow-hidden" style="background: linear-gradient(135deg, #0F2D5C 0%, #0a1f40 100%);">
    <div class="container py-4 text-center">
        <h1 class="display-4 fw-bold mb-2 text-white">Ajukan Penawaran Proyek</h1>
        <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
            Dapatkan perhitungan estimasi rancangan anggaran biaya (RAB) serta perencanaan struktur baja Anda gratis.
        </p>
    </div>
</div>

<!-- Quotation Form Container -->
<div class="py-5 bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 reveal">
                <div class="card border rounded-4 shadow-sm p-4 p-md-5 bg-white">
                    <h3 class="fw-bold text-navy mb-4 border-bottom pb-3"><i class="bi bi-file-earmark-spreadsheet-fill text-warning me-2"></i>Formulir Request Quotation</h3>
                    
                    <!-- Progress Bar for Upload -->
                    <div id="upload-progress-container" class="progress mb-4 d-none" style="height: 25px; border-radius: 15px; overflow: hidden;">
                        <div id="upload-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated bg-warning text-dark fw-bold" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>

                    <form id="quotationForm" action="{{ route('public.quotation.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <!-- Nama Lengkap -->
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold text-navy">Nama Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control border-start-0 py-2" id="name" name="name" required placeholder="Masukkan nama lengkap Anda">
                                </div>
                            </div>
                            
                            <!-- Nama Perusahaan -->
                            <div class="col-md-6">
                                <label for="company_name" class="form-label fw-semibold text-navy">Nama Perusahaan / Organisasi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-briefcase"></i></span>
                                    <input type="text" class="form-control border-start-0 py-2" id="company_name" name="company_name" placeholder="Contoh: PT Bangun Sejahtera">
                                </div>
                            </div>
                            
                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold text-navy">Alamat Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control border-start-0 py-2" id="email" name="email" required placeholder="nama@email.com">
                                </div>
                            </div>
                            
                            <!-- WhatsApp -->
                            <div class="col-md-6">
                                <label for="whatsapp" class="form-label fw-semibold text-navy">Nomor WhatsApp / Phone <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-whatsapp"></i></span>
                                    <input type="text" class="form-control border-start-0 py-2" id="whatsapp" name="whatsapp" required placeholder="Contoh: 08123456789">
                                </div>
                            </div>
                            
                            <!-- Jenis Proyek -->
                            <div class="col-md-6">
                                <label for="project_type" class="form-label fw-semibold text-navy">Jenis Proyek Konstruksi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-gear"></i></span>
                                    <select class="form-select border-start-0 py-2" id="project_type" name="project_type" required>
                                        <option value="" disabled selected>Pilih Jenis Proyek</option>
                                        <option value="Konstruksi Gudang">Konstruksi Gudang</option>
                                        <option value="Konstruksi Baja">Konstruksi Baja</option>
                                        <option value="Fabrikasi Baja">Fabrikasi Baja</option>
                                        <option value="Steel Erection">Steel Erection</option>
                                        <option value="Bangunan Industri / Pabrik">Bangunan Industri / Pabrik</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Lokasi Proyek -->
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-semibold text-navy">Lokasi Rencana Proyek <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" class="form-control border-start-0 py-2" id="location" name="location" required placeholder="Contoh: Karawang, Jawa Barat">
                                </div>
                            </div>
                            
                            <!-- Luas Bangunan -->
                            <div class="col-md-6">
                                <label for="building_area" class="form-label fw-semibold text-navy">Perkiraan Luas Bangunan (m²)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-fullscreen"></i></span>
                                    <input type="text" class="form-control border-start-0 py-2" id="building_area" name="building_area" placeholder="Contoh: 2000 m²">
                                </div>
                            </div>
                            
                            <!-- Estimasi Anggaran -->
                            <div class="col-md-6">
                                <label for="budget" class="form-label fw-semibold text-navy">Estimasi Rencana Anggaran (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-cash"></i></span>
                                    <select class="form-select border-start-0 py-2" id="budget" name="budget">
                                        <option value="" disabled selected>Pilih Kisaran Anggaran</option>
                                        <option value="< 500 Juta">< 500 Juta IDR</option>
                                        <option value="500 Juta - 1 Milyar">500 Juta - 1 Milyar IDR</option>
                                        <option value="1 Milyar - 5 Milyar">1 Milyar - 5 Milyar IDR</option>
                                        <option value="5 Milyar - 10 Milyar">5 Milyar - 10 Milyar IDR</option>
                                        <option value="> 10 Milyar">> 10 Milyar IDR</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Deskripsi -->
                            <div class="col-12">
                                <label for="description" class="form-label fw-semibold text-navy">Deskripsi Rencana & Spesifikasi Pekerjaan</label>
                                <textarea class="form-control py-3" id="description" name="description" rows="5" placeholder="Tuliskan spesifikasi bentang tiang, tinggi bangunan, plat lantai, dinding, kelengkapan atap, dsb..."></textarea>
                            </div>
                            
                            <!-- Upload Dokumen / Blueprints -->
                            <div class="col-12">
                                <label for="attachment" class="form-label fw-semibold text-navy">Upload Denah / DED / Gambar Kerja (Opsional)</label>
                                <div class="border border-dashed rounded-3 p-4 text-center bg-light">
                                    <i class="bi bi-cloud-arrow-up text-warning fs-1"></i>
                                    <p class="text-muted text-sm mt-2 mb-3">Tarik & letakkan file Anda di sini, atau klik untuk memilih file</p>
                                    <input type="file" class="form-control d-inline-block w-auto text-sm" id="attachment" name="attachment" style="max-width: 350px;">
                                    <span class="d-block text-muted text-xs mt-2">Format: PDF, Word, JPG, PNG, ZIP, RAR. Maksimal ukuran file: 10MB</span>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="col-12 mt-4">
                                <button type="submit" id="submitBtn" class="btn btn-navy btn-ripple w-100 py-3 text-white shadow-lg fw-bold fs-5">
                                    Kirim Pengajuan Quotation
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('quotationForm');
    const submitBtn = document.getElementById('submitBtn');
    const progressContainer = document.getElementById('upload-progress-container');
    const progressBar = document.getElementById('upload-progress-bar');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengirim Pengajuan...';
        
        // Show progress bar
        progressContainer.classList.remove('d-none');
        progressBar.style.width = '10%';
        progressBar.innerText = '10%';

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        
        // Monitor progress upload
        xhr.upload.addEventListener('progress', (event) => {
            if (event.lengthComputable) {
                const percentComplete = Math.round((event.loaded / event.total) * 100);
                progressBar.style.width = percentComplete + '%';
                progressBar.innerText = percentComplete + '%';
            }
        });

        xhr.addEventListener('load', () => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Kirim Pengajuan Quotation';
            progressContainer.classList.add('d-none');
            
            if (xhr.status >= 200 && xhr.status < 300) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    showToast(response.message, true);
                    form.reset();
                } else {
                    showToast('Ada kesalahan dalam pengiriman form.', false);
                }
            } else {
                showToast('Gagal mengirim pengajuan. Silakan periksa kembali berkas/koneksi Anda.', false);
            }
        });

        xhr.addEventListener('error', () => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Kirim Pengajuan Quotation';
            progressContainer.classList.add('d-none');
            showToast('Koneksi internet bermasalah. Pengajuan gagal dikirim.', false);
        });

        xhr.open('POST', form.action);
        // Include CSRF Header if needed, but it is already in FormData
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(formData);
    });
});
</script>
@endsection
