@extends('template_admin.layout')

@section('content')
<section class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/dashboard-asisten">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('produk.index') }}">Produk</a></li>
                            <li class="breadcrumb-item" aria-current="page">Detail Produk</li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h2 class="mb-0">Detail Produk</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bx bx-package me-2"></i>Detail Produk
                        </h5>
                        <div>
                            <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-primary">
                                <i class="bx bx-edit me-1"></i> Edit
                            </a>
                            <a href="{{ route('produk.index') }}" class="btn btn-light">
                                <i class="bx bx-arrow-back me-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Gambar Produk -->
                            <div class="col-lg-4 col-md-5 mb-4">
                                <div class="text-center">
                                    <div class="position-relative d-inline-block">
                                        <img src="{{ asset('upload/produk/' . $produk->gambar) }}" 
                                             alt="{{ $produk->judul }}"
                                             class="img-fluid rounded shadow-lg" 
                                             style="max-width: 100%; height: 300px; object-fit: cover; border: 3px solid #e9ecef;">
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-success">
                                                <i class="bx bx-check-circle me-1"></i>Aktif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Informasi Produk -->
                            <div class="col-lg-8 col-md-7">
                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="text-primary mb-3">{{ $produk->judul }}</h3>
                                        
                                        <!-- Kategori -->
                                        <div class="mb-3">
                                            <span class="badge bg-info fs-6 px-3 py-2">
                                                <i class="bx bx-category me-1"></i>
                                                {{ $produk->kategoriProduk->kategori_produk ?? 'Tidak ada kategori' }}
                                            </span>
                                        </div>

                                        <!-- Slug -->
                                        <div class="mb-3">
                                            <small class="text-muted">
                                                <i class="bx bx-link me-1"></i>Slug: 
                                                <code class="bg-light px-2 py-1 rounded">{{ $produk->slug }}</code>
                                            </small>
                                        </div>

                                        <!-- Deskripsi -->
                                        <div class="mb-4">
                                            <h6 class="text-dark mb-2">
                                                <i class="bx bx-file-text me-2"></i>Deskripsi Produk
                                            </h6>
                                            <div class="border rounded p-3 bg-light">
                                                {!! $produk->deskripsi !!}
                                            </div>
                                        </div>

                                        <!-- Informasi Tanggal -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card border-0 bg-light">
                                                    <div class="card-body p-3">
                                                        <h6 class="card-title text-muted mb-2">
                                                            <i class="bx bx-calendar-plus me-2"></i>Tanggal Dibuat
                                                        </h6>
                                                        <p class="card-text mb-0 fw-semibold">
                                                            {{ $produk->created_at->format('d F Y') }}
                                                        </p>
                                                        <small class="text-muted">
                                                            {{ $produk->created_at->format('H:i') }} WIB
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card border-0 bg-light">
                                                    <div class="card-body p-3">
                                                        <h6 class="card-title text-muted mb-2">
                                                            <i class="bx bx-calendar-edit me-2"></i>Terakhir Diperbarui
                                                        </h6>
                                                        <p class="card-text mb-0 fw-semibold">
                                                            {{ $produk->updated_at->format('d F Y') }}
                                                        </p>
                                                        <small class="text-muted">
                                                            {{ $produk->updated_at->format('H:i') }} WIB
                                                        </small>
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
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</section>
@endsection