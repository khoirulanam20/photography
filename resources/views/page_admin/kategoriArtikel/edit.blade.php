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
                <li class="breadcrumb-item"><a href="{{ route('kategoriArtikel.index') }}">Kategori Artikel</a></li>
                <li class="breadcrumb-item" aria-current="page">Form Edit Kategori Artikel</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Form Edit Kategori Artikel</h2>
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
              <h5>Form Edit Kategori Artikel</h5>
            </div>
            <div class="card-body">
              <form action="{{ route('kategoriArtikel.update', $kategoriArtikel->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label class="form-label" for="kategori_artikel">Kategori Artikel</label>
                  <input type="text" id="kategori_artikel" name="kategori_artikel" class="form-control @error('kategori_artikel') is-invalid @enderror" value="{{ old('kategori_artikel', $kategoriArtikel->kategori_artikel) }}" required>
                  @error('kategori_artikel')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary me-2">Submit</button>
                  <a href="{{ route('kategoriArtikel.index') }}" class="btn btn-light">Batal</a>
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