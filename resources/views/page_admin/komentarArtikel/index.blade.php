@extends('template_admin.layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Komentar Artikel /</span> Daftar Komentar
        </h4>
        <a href="{{ route('komentarArtikel.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Tambah Komentar
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Komentar Artikel</h5>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Cari...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="bx bx-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Artikel</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Komentar</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($komentarArtikels as $index => $komentar)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <a href="{{ route('artikel.show', $komentar->artikel_id) }}" class="text-primary">
                                    {{ Str::limit($komentar->artikel->judul, 30) }}
                                </a>
                            </td>
                            <td>{{ $komentar->nama_komentar }}</td>
                            <td>{{ $komentar->email_komentar }}</td>
                            <td>{{ $komentar->no_hp_komentar }}</td>
                            <td>{{ Str::limit($komentar->komentar, 50) }}</td>
                            <td>{{ $komentar->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('komentarArtikel.show', $komentar->id) }}" 
                                       class="btn btn-sm btn-info" 
                                       data-bs-toggle="tooltip" 
                                       title="Detail">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="{{ route('komentarArtikel.edit', $komentar->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('komentarArtikel.destroy', $komentar->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bx bx-message-square-x text-muted" style="font-size: 3rem;"></i>
                                    <p class="mt-2 mb-0">Belum ada komentar artikel</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-4">
                {{ $komentarArtikels->links() }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
    }
    .btn-group .btn i {
        font-size: 1rem;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endpush

@push('scripts')
<script>
    // Inisialisasi tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush
@endsection 