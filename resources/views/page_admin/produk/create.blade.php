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
                <li class="breadcrumb-item" aria-current="page">Form Tambah Produk</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Form Tambah Produk</h2>
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
              <h5 class="mb-0">Form Tambah Produk</h5>
            </div>
            <div class="card-body">
              @if (session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-3">
                  <label class="form-label" for="judul">Judul Produk</label>
                  <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" placeholder="Masukkan judul produk" />
                  @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label class="form-label" for="master_kategori_produk_id">Kategori Produk</label>
                  <select class="form-select @error('master_kategori_produk_id') is-invalid @enderror" id="master_kategori_produk_id" name="master_kategori_produk_id">
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoriProduks as $kategori)
                      <option value="{{ $kategori->id }}" {{ old('master_kategori_produk_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->kategori_produk }}
                      </option>
                    @endforeach
                  </select>
                  @error('master_kategori_produk_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label class="form-label" for="gambar">Gambar Produk</label>
                  <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*" />
                  @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group mb-3">
                  <label class="form-label" for="deskripsi">Deskripsi</label>
                  <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5" placeholder="Masukkan deskripsi produk">{{ old('deskripsi') }}</textarea>
                  @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary me-2">Submit</button>
                  <a href="{{ route('produk.index') }}" class="btn btn-light">Batal</a>
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
<script src="{{ asset('admin/assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
<script>
  let editor;
  
  document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi CKEditor
    ClassicEditor.create(document.querySelector('#deskripsi'))
      .then(editorInstance => {
        editor = editorInstance;
      })
      .catch((error) => {
        console.error(error);
      });
  });
</script>
@endsection