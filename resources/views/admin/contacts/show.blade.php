@extends('layouts.admin')

@section('title', 'Baca Pesan - Admin Dashboard')
@section('page-title', 'Pesan dari: ' . $contact->name)

@section('admin-content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5 bg-white">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 border-bottom pb-3">
                <div>
                    <h5 class="fw-bold text-navy mb-1"><i class="bi bi-envelope-paper-fill text-warning me-2"></i>{{ $contact->subject }}</h5>
                    <span class="text-xs text-muted">Dikirim pada: {{ $contact->created_at->format('d M Y - H:i:s') }} WIB</span>
                </div>
                <div class="mt-2 mt-sm-0">
                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash me-1"></i> Hapus Pesan</button>
                    </form>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <span class="text-muted text-xs d-block">NAMA PENGIRIM</span>
                    <strong class="text-navy fs-6">{{ $contact->name }}</strong>
                </div>
                <div class="col-md-4">
                    <span class="text-muted text-xs d-block">ALAMAT EMAIL</span>
                    <strong class="text-navy fs-6">{{ $contact->email }}</strong>
                </div>
                <div class="col-md-4">
                    <span class="text-muted text-xs d-block">NOMOR WHATSAPP</span>
                    <strong class="text-navy fs-6">{{ $contact->whatsapp ?? '-' }}</strong>
                </div>
            </div>

            <span class="text-muted text-xs d-block mb-2">ISI PESAN</span>
            <div class="bg-light p-4 rounded border text-muted leading-relaxed" style="min-height: 200px;">
                {!! nl2br(e($contact->message)) !!}
            </div>

            <div class="mt-4 border-top pt-3 text-end">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-navy text-white fw-bold px-4">Kembali ke Inbox</a>
            </div>
        </div>
    </div>
</div>
@endsection
