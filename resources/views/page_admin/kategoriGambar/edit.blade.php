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
                <li class="breadcrumb-item"><a href="{{ route('kategoriGambar.index') }}">Kategori Gambar</a></li>
                <li class="breadcrumb-item" aria-current="page">Form Edit Kategori Gambar</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Form Edit Kategori Gambar</h2>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->

      <!-- [ Main Content ] start -->
      <div class="row justify-content-center">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Form Edit Kategori Gambar</h5>
            </div>
            <div class="card-body">
              <form action="{{ route('kategoriGambar.update', $kategoriGambar->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                  <label for="kategori_gambar" class="form-label">Kategori Gambar</label>
                  <input type="text" class="form-control @error('kategori_gambar') is-invalid @enderror" id="kategori_gambar" name="kategori_gambar" value="{{ old('kategori_gambar', $kategoriGambar->kategori_gambar) }}" placeholder="Masukkan kategori gambar">
                  @error('kategori_gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label for="deskripsi" class="form-label">Deskripsi</label>
                  <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Masukkan deskripsi">{{ old('deskripsi', $kategoriGambar->deskripsi) }}</textarea>
                  @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary me-2">Submit</button>
                  <a href="{{ route('kategoriGambar.index') }}" class="btn btn-light">Batal</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- [ Main Content ] end -->
    </div>
  </section>
@endsection

@section('script')
@endsection







