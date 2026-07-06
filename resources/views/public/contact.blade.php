@extends('layouts.public')

@section('title', 'Hubungi Kami Alamat & Peta - PT Multi Power Abadi')

@section('content')
<!-- Page Header -->
<div class="page-header-banner bg-navy text-white position-relative overflow-hidden d-flex align-items-center" style="background: linear-gradient(135deg, rgba(15, 45, 92, 0.85) 0%, rgba(10, 31, 64, 0.88) 100%), url('{{ asset('images/page-header-bg.jpg') }}') center/cover no-repeat !important; padding-top: 170px; padding-bottom: 160px; min-height: 400px;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-2 text-white">Hubungi Kami</h1>
        <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
            Hubungi tim estimator dan sales kami untuk menjadwalkan rapat survey lapangan atau presentasi produk.
        </p>
    </div>
</div>

<!-- Contact & Form Section -->
<div class="py-5 bg-white">
    <div class="container">
        <div class="row g-5">
            <!-- Left Info Block -->
            <div class="col-lg-5 reveal reveal-left">
                <div class="card border rounded-4 p-4 shadow-sm bg-light">
                    <h3 class="fw-bold text-navy mb-4">Informasi Kontak</h3>

                    <div class="d-flex gap-3 mb-4">
                        <div class="bg-navy text-white rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 shadow" style="width: 50px; height: 50px; font-size: 1.3rem;">
                            <i class="bi bi-telephone-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-navy mb-1">WhatsApp &amp; HP</h5>
                            <p class="text-muted mb-0">+62 811-272-825</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4">
                        <div class="bg-navy text-white rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 shadow" style="width: 50px; height: 50px; font-size: 1.3rem;">
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-navy mb-1">Alamat Email</h5>
                            <p class="text-muted mb-0" style="word-break: break-all;">multipowerabadi@gmail.com</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="bg-navy text-white rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 shadow" style="width: 50px; height: 50px; font-size: 1.3rem;">
                            <i class="bi bi-clock-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-navy mb-1">Jam Operasional</h5>
                            <p class="text-muted mb-0">24 Jam</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Message Form -->
            <div class="col-lg-7 reveal reveal-right" style="transition-delay: 0.2s;">
                <h3 class="fw-bold text-navy mb-4">Kirim Pesan Langsung</h3>
                <form id="contactForm" action="{{ route('public.contact.submit') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold text-navy">Nama Lengkap *</label>
                            <input type="text" class="form-control py-2" id="name" name="name" required placeholder="Masukkan nama Anda">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold text-navy">Alamat Email *</label>
                            <input type="email" class="form-control py-2" id="email" name="email" required placeholder="nama@email.com">
                        </div>
                        <div class="col-md-12">
                            <label for="whatsapp" class="form-label fw-semibold text-navy">Nomor WhatsApp / HP (Opsional)</label>
                            <input type="text" class="form-control py-2" id="whatsapp" name="whatsapp" placeholder="Contoh: 08123456789">
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label fw-semibold text-navy">Subjek Pesan *</label>
                            <input type="text" class="form-control py-2" id="subject" name="subject" required placeholder="Contoh: Tanya Harga WF, Rencana Survey Gudang">
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label fw-semibold text-navy">Isi Pesan / Keterangan *</label>
                            <textarea class="form-control py-2" id="message" name="message" rows="5" required placeholder="Tuliskan pesan detail Anda di sini..."></textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" id="submitBtn" class="btn btn-navy btn-ripple w-100 py-3 text-white shadow fw-bold">
                                Kirim Pesan Saya
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengirim Pesan...';

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();
        
        xhr.addEventListener('load', () => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Kirim Pesan Saya';
            
            if (xhr.status >= 200 && xhr.status < 300) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    showToast(response.message, true);
                    form.reset();
                } else {
                    showToast('Ada kesalahan dalam pengiriman form.', false);
                }
            } else {
                showToast('Gagal mengirim pesan. Silakan periksa kolom input.', false);
            }
        });

        xhr.open('POST', form.action);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.send(formData);
    });
});
</script>
@endsection
