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
                <li class="breadcrumb-item"><a href="javascript: void(0)">Beranda</a></li>
                <li class="breadcrumb-item" aria-current="page">Detail Data Beranda</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Detail Data Beranda</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row justify-content-center">
        <div class="col-sm-10">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Detail Data Beranda</h5>
              <div>
                <a href="{{ route('beranda.edit', $beranda->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('beranda.index') }}" class="btn btn-light">Kembali</a>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-4">
                    <h6 class="fw-bold">Gambar Utama</h6>
                    @if ($beranda->gambar_utama)
                      <img src="{{ asset('upload/beranda/' . $beranda->gambar_utama) }}" alt="Gambar Utama" class="img-fluid rounded" style="max-height: 300px;">
                    @else
                      <div class="bg-light rounded p-4 text-center">
                        <i class="bx bx-image" style="font-size: 3rem;"></i>
                        <p class="mt-2 mb-0">Tidak ada gambar</p>
                      </div>
                    @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-4">
                    <h6 class="fw-bold">Gambar Sekunder</h6>
                    @if ($beranda->gambar_sekunder)
                      <img src="{{ asset('upload/beranda/' . $beranda->gambar_sekunder) }}" alt="Gambar Sekunder" class="img-fluid rounded" style="max-height: 300px;">
                    @else
                      <div class="bg-light rounded p-4 text-center">
                        <i class="bx bx-image" style="font-size: 3rem;"></i>
                        <p class="mt-2 mb-0">Tidak ada gambar</p>
                      </div>
                    @endif
                  </div>
                </div>
              </div>

              <div class="row mt-4">
                <div class="col-md-6">
                  <div class="mb-3">
                    <h6 class="fw-bold">Judul Utama</h6>
                    <p class="mb-0">{{ $beranda->judul_utama }}</p>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <h6 class="fw-bold">Judul Sekunder</h6>
                    <p class="mb-0">{{ $beranda->judul_sekunder }}</p>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <h6 class="fw-bold">Slogan</h6>
                    <p class="mb-0">{{ $beranda->slogan }}</p>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="mb-3">
                    <h6 class="fw-bold">Keterangan</h6>
                    <p class="mb-0">{!! $beranda->keterangan !!}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection