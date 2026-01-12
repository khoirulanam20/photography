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
                <li class="breadcrumb-item" aria-current="page">Form Tambah Data Beranda</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Form Tambah Data Beranda</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row justify-content-center">
        <!-- [ form-element ] start -->
        <div class="col-sm-8">
          <!-- Basic Inputs -->
          <div class="card">
            <div class="card-header">
              <h5>Form Tambah Data Beranda</h5>
            </div>
            <div class="card-body">
              <form action="{{ route('beranda.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Judul Utama</label>
                      <input type="text" name="judul_utama" class="form-control @error('judul_utama') is-invalid @enderror" value="{{ old('judul_utama') }}" placeholder="Masukkan judul utama" required>
                      @error('judul_utama')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Judul Sekunder</label>
                      <input type="text" name="judul_sekunder" class="form-control @error('judul_sekunder') is-invalid @enderror" value="{{ old('judul_sekunder') }}" placeholder="Masukkan judul sekunder" required>
                      @error('judul_sekunder')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-label">Slogan</label>
                      <input type="text" name="slogan" class="form-control @error('slogan') is-invalid @enderror" value="{{ old('slogan') }}" placeholder="Masukkan slogan" required>
                      @error('slogan')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Gambar Utama</label>
                      <input type="file" name="gambar_utama" class="form-control @error('gambar_utama') is-invalid @enderror" accept="image/*">
                      <small class="text-muted">Format: JPG, JPEG, PNG, GIF, SVG. Maksimal 2MB</small>
                      @error('gambar_utama')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Gambar Sekunder</label>
                      <input type="file" name="gambar_sekunder" class="form-control @error('gambar_sekunder') is-invalid @enderror" accept="image/*">
                      <small class="text-muted">Format: JPG, JPEG, PNG, GIF, SVG. Maksimal 2MB</small>
                      @error('gambar_sekunder')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-label">Keterangan</label>
                      <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" rows="4" placeholder="Masukkan keterangan" required>{{ old('keterangan') }}</textarea>
                      @error('keterangan')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary me-2">Submit</button>
                  <button type="reset" class="btn btn-light">Reset</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection