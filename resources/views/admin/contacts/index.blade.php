@extends('layouts.admin')

@section('title', 'Inbox Pesan - Admin Dashboard')
@section('page-title', 'Pesan Hubungi Kami')

@section('admin-content')
<div class="card border-0 shadow-sm rounded-3">
    <div class="card-header bg-white py-3">
        <h5 class="card-title text-navy mb-0 fw-bold"><i class="bi bi-chat-left-text-fill text-warning me-2"></i>Daftar Pesan Masuk</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light text-navy fw-bold text-xs uppercase">
                    <tr>
                        <th class="ps-3">Pengirim</th>
                        <th>Subjek</th>
                        <th>WhatsApp</th>
                        <th>Status</th>
                        <th>Tanggal Pesan</th>
                        <th class="text-end pe-3" style="width: 120px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr class="{{ !$contact->is_read ? 'table-warning fw-semibold' : '' }}">
                            <td class="ps-3">
                                <strong class="text-navy d-block">{{ $contact->name }}</strong>
                                <span class="text-xs text-muted">{{ $contact->email }}</span>
                            </td>
                            <td>{{ Str::limit($contact->subject, 50) }}</td>
                            <td>{{ $contact->whatsapp ?? '-' }}</td>
                            <td>
                                @if(!$contact->is_read)
                                    <span class="badge bg-danger text-white text-xs uppercase px-2">Baru</span>
                                @else
                                    <span class="badge bg-secondary text-white text-xs uppercase px-2">Dibaca</span>
                                @endif
                            </td>
                            <td>{{ $contact->created_at->format('d M Y, H:i') }} WIB</td>
                            <td class="text-end pe-3">
                                <div class="btn-group">
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-outline-primary btn-sm me-1 rounded"><i class="bi bi-eye"></i> Baca</a>
                                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada pesan kontak masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $contacts->links('pagination::bootstrap-5') }}
</div>
@endsection
