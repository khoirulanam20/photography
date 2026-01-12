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
                <li class="breadcrumb-item"><a href="{{ route('kategoriProduk.index') }}">Kategori Produk</a></li>
                <li class="breadcrumb-item" aria-current="page">Form Edit Kategori Produk</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Form Edit Kategori Produk</h2>
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
              <h5 class="mb-0">Form Edit Kategori Produk</h5>
            </div>
            <div class="card-body">
              @if (session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
              <form action="{{ route('kategoriProduk.update', $kategoriProduk->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                  <label class="form-label" for="kategori_produk">Kategori Produk</label>
                  <input type="text" class="form-control @error('kategori_produk') is-invalid @enderror" id="kategori_produk" name="kategori_produk" value="{{ old('kategori_produk', $kategoriProduk->kategori_produk) }}" placeholder="Masukkan kategori produk" />
                  @error('kategori_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label class="form-label" for="deskripsi">Deskripsi</label>
                  <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" placeholder="Masukkan deskripsi kategori">{{ old('deskripsi', $kategoriProduk->deskripsi) }}</textarea>
                  @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary me-2">Submit</button>
                  <a href="{{ route('kategoriProduk.index') }}" class="btn btn-light">Batal</a>
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