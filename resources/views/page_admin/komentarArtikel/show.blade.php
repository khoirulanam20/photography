@extends('template_admin.layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Komentar Artikel /</span> Detail Komentar
        </h4>
        <div>
            <a href="{{ route('komentarArtikel.edit', $komentarArtikel->id) }}" class="btn btn-warning">
                <i class="bx bx-edit"></i> Edit
            </a>
            <a href="{{ route('komentarArtikel.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Detail Komentar</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Artikel</h6>
                                <a href="{{ route('artikel.show', $komentarArtikel->artikel_id) }}" class="text-primary">
                                    {{ $komentarArtikel->artikel->judul }}
                                </a>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Informasi Pengirim</h6>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-user text-primary me-2"></i>
                                    <span>{{ $komentarArtikel->nama_komentar }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-envelope text-primary me-2"></i>
                                    <span>{{ $komentarArtikel->email_komentar }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-phone text-primary me-2"></i>
                                    <span>{{ $komentarArtikel->no_hp_komentar }}</span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Tanggal Komentar</h6>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-calendar text-primary me-2"></i>
                                    <span>{{ $komentarArtikel->created_at->format('d F Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-muted mb-2">Isi Komentar</h6>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <p class="mb-0">{{ $komentarArtikel->komentar }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(161, 172, 184, 0.075);
    }
    .text-muted {
        font-size: 0.875rem;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
@endpush
@endsection 