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
              <li class="breadcrumb-item"><a href="{{ route('komentarArtikel.index') }}">Komentar Artikel</a></li>
              <li class="breadcrumb-item" aria-current="page">Form Tambah Komentar</li>
            </ul>
          </div>
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0">Form Tambah Komentar</h2>
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
            <h5 class="card-title mb-0">Form Tambah Komentar</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('komentarArtikel.store') }}" method="POST">
              @csrf
              <div class="form-group mb-3">
                <label for="artikel_id" class="form-label">Artikel</label>
                <select class="form-select @error('artikel_id') is-invalid @enderror" id="artikel_id" name="artikel_id" required>
                  <option value="">Pilih Artikel</option>
                  @foreach($artikels as $artikel)
                    <option value="{{ $artikel->id }}" {{ old('artikel_id') == $artikel->id ? 'selected' : '' }}>{{ $artikel->judul }}</option>
                  @endforeach
                </select>
                @error('artikel_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group mb-3">
                <label for="nama_komentar" class="form-label">Nama</label>
                <input type="text" class="form-control @error('nama_komentar') is-invalid @enderror" id="nama_komentar" name="nama_komentar" value="{{ old('nama_komentar') }}" required>
                @error('nama_komentar')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group mb-3">
                <label for="email_komentar" class="form-label">Email</label>
                <input type="email" class="form-control @error('email_komentar') is-invalid @enderror" id="email_komentar" name="email_komentar" value="{{ old('email_komentar') }}" required>
                @error('email_komentar')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group mb-3">
                <label for="no_hp_komentar" class="form-label">No HP</label>
                <input type="text" class="form-control @error('no_hp_komentar') is-invalid @enderror" id="no_hp_komentar" name="no_hp_komentar" value="{{ old('no_hp_komentar') }}" required>
                @error('no_hp_komentar')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group mb-3">
                <label for="komentar" class="form-label">Komentar</label>
                <textarea class="form-control @error('komentar') is-invalid @enderror" id="komentar" name="komentar" rows="6" required>{{ old('komentar') }}</textarea>
                @error('komentar')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary me-2">Submit</button>
                <a href="{{ route('komentarArtikel.index') }}" class="btn btn-light">Batal</a>
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