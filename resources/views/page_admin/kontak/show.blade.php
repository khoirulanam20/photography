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
                <li class="breadcrumb-item"><a href="javascript: void(0)">Kontak</a></li>
                <li class="breadcrumb-item" aria-current="page">Detail Data Kontak</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Detail Data Kontak</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row justify-content-center">
        <div class="col-sm-8">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Detail Data Kontak</h5>
              <div>
                <a href="{{ route('kontak.edit', $kontak->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('kontak.index') }}" class="btn btn-light">Kembali</a>
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-3">
                <div class="col-md-3 fw-bold">Nama</div>
                <div class="col-md-9">: {{ $kontak->nama }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-md-3 fw-bold">Email</div>
                <div class="col-md-9">: {{ $kontak->email }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-md-3 fw-bold">No. HP</div>
                <div class="col-md-9">: {{ $kontak->no_hp }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-md-3 fw-bold">Pesan</div>
                <div class="col-md-9">: {{ $kontak->pesan }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-md-3 fw-bold">Tanggal Dibuat</div>
                <div class="col-md-9">: {{ $kontak->created_at->format('d F Y H:i') }}</div>
              </div>

              <div class="row mb-3">
                <div class="col-md-3 fw-bold">Terakhir Diperbarui</div>
                <div class="col-md-9">: {{ $kontak->updated_at->format('d F Y H:i') }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection