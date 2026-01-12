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
                <li class="breadcrumb-item" aria-current="page">Form Tambah Data Kontak</li>
              </ul>
            </div>
            <div class="col-md-12">
              <div class="page-header-title">
                <h2 class="mb-0">Form Tambah Data Kontak</h2>
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
              <h5>Form Tambah Data Kontak</h5>
            </div>
            <div class="card-body">
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              <form action="{{ route('kontak.store') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label class="form-label">Nama</label>
                  <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Masukkan nama" required>
                  @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Masukkan email" required>
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="form-label">No. HP</label>
                  <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" placeholder="Masukkan nomor HP" required>
                  @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="form-label">Alamat</label>
                  <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                  @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="form-label">Pesan</label>
                  <textarea name="pesan" class="form-control @error('pesan') is-invalid @enderror" rows="5" placeholder="Masukkan pesan" required>{{ old('pesan') }}</textarea>
                  @error('pesan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <label class="form-label">Status</label>
                  <select name="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="">Pilih Status</option>
                    <option value="Belum Dibaca" {{ old('status') == 'Belum Dibaca' ? 'selected' : '' }}>Belum Dibaca</option>
                    <option value="Dibaca" {{ old('status') == 'Dibaca' ? 'selected' : '' }}>Dibaca</option>
                  </select>
                  @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
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