@extends('layouts.public')

@section('title', 'Layanan Konstruksi & Fabrikasi Baja - PT Multi Power Abadi')

@section('content')
<!-- Page Header -->
<div class="page-header-banner text-white position-relative overflow-hidden d-flex align-items-center" style="padding-top: 170px; padding-bottom: 160px; min-height: 400px;">
    <div class="container text-center">
        <span class="badge bg-danger text-white px-3 py-2 rounded-pill text-uppercase fw-semibold mb-3 d-inline-block shadow-sm" style="letter-spacing: 1.5px;">
            <i class="bi bi-gear-wide-connected me-1"></i> SPESIALIS STRUKTUR BAJA INDUSTRI
        </span>
        <h1 class="display-4 fw-bold mb-3 text-white">Layanan Konstruksi Baja Terpadu</h1>
        <p class="lead text-white-50 mx-auto" style="max-width: 680px; line-height: 1.6;">
            Solusi rancang bangun terintegrasi dari rekayasa teknik (engineering), fabrikasi mandiri, hingga pemasangan rangka baja bentang lebar yang presisi dan bergaransi.
        </p>
    </div>
</div>

<!-- Services Grid -->
<div class="py-5 bg-light">
    <div class="container py-3">
        @php
            $constructionServices = [
                [
                    'title' => 'Konstruksi Gudang Baja',
                    'desc' => 'Desain & pembangunan gudang bentang lebar tanpa tiang tengah, mengoptimalkan kapasitas penyimpanan dan kelancaran alur logistik.',
                    'icon' => 'bi-building-fill',
                    'img' => asset('images/konstruksi-gudang-baja.jpg')
                ],
                [
                    'title' => 'Konstruksi Pabrik Baja',
                    'desc' => 'Struktur pabrik industri heavy-duty yang dirancang khusus menahan beban mesin produksi dan crane operasional secara aman.',
                    'icon' => 'bi-building-gear',
                    'img' => asset('images/konstruksi-pabrik-baja.jpg')
                ],
                [
                    'title' => 'Konstruksi Hanggar Baja',
                    'desc' => 'Konstruksi bentang ekstra lebar dengan sistem rangka baja kokoh yang tahan terhadap beban angin dan cuaca ekstrem.',
                    'icon' => 'bi-airplane',
                    'img' => asset('images/konstruksi-hanggar-baja.jpg')
                ],
                [
                    'title' => 'Konstruksi Workshop Baja',
                    'desc' => 'Fasilitas kerja dan bengkel industri dengan efisiensi tata ruang tinggi, pencahayaan alami, dan sirkulasi udara optimal.',
                    'icon' => 'bi-tools',
                    'img' => asset('images/konstruksi-workshop-baja.jpg')
                ],
                [
                    'title' => 'Konstruksi Gedung Baja',
                    'desc' => 'Sistem struktur baja multilantai yang cepat dibangun, fleksibel untuk ekspansi bisnis, serta tahan beban gempa.',
                    'icon' => 'bi-building',
                    'img' => asset('images/konstruksi-struktur-gedung-baja.png')
                ],
                [
                    'title' => 'Konstruksi Mezzanine Baja',
                    'desc' => 'Solusi cepat menambah luas area kerja vertikal tanpa merusak atau mengubah struktur utama bangunan gudang Anda.',
                    'icon' => 'bi-layers-half',
                    'img' => asset('images/konstruksi-mezzanine-baja.png')
                ],
                [
                    'title' => 'Rangka Atap Baja Bentang Lebar',
                    'desc' => 'Pemasangan rangka atap baja bervolume besar yang presisi, tahan korosi, kuat menahan beban, dan minim biaya perawatan.',
                    'icon' => 'bi-house-gear-fill',
                    'img' => asset('images/konstruksi-rangka-atap-baja.jpg')
                ],
                [
                    'title' => 'Renovasi & Perkuatan Struktur',
                    'desc' => 'Peningkatan kapasitas beban dan perkuatan struktur baja eksisting agar sesuai dengan standar keselamatan operasional baru.',
                    'icon' => 'bi-shield-fill-check',
                    'img' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?q=80&w=600&auto=format&fit=crop'
                ]
            ];
        @endphp

        <div class="row g-4">
            @foreach($constructionServices as $index => $item)
                <div class="col-md-6 col-lg-3 reveal" style="transition-delay: {{ 0.08 * ($index + 1) }}s;">
                    <div class="service-card h-100 border rounded-4 shadow-sm overflow-hidden bg-white d-flex flex-column">
                        <div class="card-img-wrapper" style="height: 180px; overflow: hidden; position: relative;">
                            <img src="{{ $item['img'] }}" class="w-100 h-100 object-fit-cover transition-zoom" alt="{{ $item['title'] }}">
                        </div>
                        <div class="card-body p-4 position-relative d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="service-icon-box mb-3">
                                    <i class="bi {{ $item['icon'] }}"></i>
                                </div>
                                <h5 class="card-title fw-bold text-navy mb-2 fs-6" style="line-height: 1.4;">{{ $item['title'] }}</h5>
                                <p class="text-muted text-sm mb-0" style="font-size: 0.85rem; line-height: 1.5;">{{ $item['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Layanan Lainnya Section -->
<section id="other-services" class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5 reveal">
            <span class="text-uppercase fw-bold text-danger" style="letter-spacing: 2px; font-size: 0.85rem;">SOLUSI PENDUKUNG</span>
            <h2 class="mt-2 display-6 fw-bold text-navy">Layanan Sipil, Interior &amp; Arsitektur</h2>
            <p class="text-muted mx-auto mt-3" style="max-width: 720px; font-size: 0.95rem;">Untuk memberikan kemudahan One-Stop Solution, kami juga melayani pengerjaan sipil, mekanikal-elektrikal, serta penataan interior komersial secara profesional.</p>
        </div>

        @php
            $otherServices = [
                [
                    'title' => 'Renovasi Residensial & Komersial',
                    'desc' => 'Solusi renovasi gedung kantor, ruko, pabrik, dan fasilitas bisnis dengan pengerjaan rapi serta efisiensi anggaran.',
                    'icon' => 'bi-house-gear-fill'
                ],
                [
                    'title' => 'Design & Build Arsitektur',
                    'desc' => 'Layanan terpadu dari konsep desain arsitektur hingga eksekusi fisik pembangunan dalam satu sistem kontrol terpusat.',
                    'icon' => 'bi-vector-pen'
                ],
                [
                    'title' => 'Pekerjaan Sipil & MEP',
                    'desc' => 'Instalasi mekanikal, elektrikal, plumbing, dan perkerasan lantai beton industri sesuai regulasi keselamatan.',
                    'icon' => 'bi-lightning-charge-fill'
                ],
                [
                    'title' => 'Workshop Custom Interior',
                    'desc' => 'Produksi furniture custom, partisi kantor, dan interior fasilitas industri berstandar kualitas tinggi.',
                    'icon' => 'bi-hammer'
                ]
            ];
        @endphp

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mt-2">
            @foreach($otherServices as $index => $service)
                <div class="col reveal" style="transition-delay: {{ 0.1 * ($index + 1) }}s;">
                    <div class="other-service-card h-100 p-4 bg-white rounded-4 border shadow-sm transition-all position-relative overflow-hidden d-flex flex-column">
                        <div class="other-service-icon-box mb-4 d-inline-flex align-items-center justify-content-center rounded-3">
                            <i class="bi {{ $service['icon'] }}"></i>
                        </div>
                        <h5 class="fw-bold text-navy mb-3 fs-6" style="line-height: 1.4;">{{ $service['title'] }}</h5>
                        <p class="text-muted text-sm mb-0 flex-grow-1" style="font-size: 0.88rem; line-height: 1.6;">{{ $service['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Request Quotation -->
<section class="py-5 bg-navy text-white text-center">
    <div class="container py-3 reveal">
        <h3 class="fw-bold mb-3 text-white">Butuh Solusi Rekayasa Khusus Untuk Proyek Industri Anda?</h3>
        <p class="text-white-50 mb-4 mx-auto" style="max-width: 650px; font-size: 1.05rem;">Tim engineer ahli PT Multi Power Abadi siap membantu perhitungan tonase baja, RAB, serta konsultasi gratis untuk efisiensi biaya proyek Anda.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('public.quotation') }}" class="btn btn-warning btn-lg btn-ripple text-navy fw-semibold px-4 shadow">
                <i class="bi bi-file-earmark-spreadsheet-fill me-2"></i>Minta Penawaran Proyek
            </a>
            <a href="https://wa.me/62811272825" target="_blank" rel="noopener noreferrer" class="btn btn-outline-white btn-lg btn-ripple px-4 fw-semibold">
                <i class="bi bi-whatsapp me-2"></i>Konsultasi via WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection

