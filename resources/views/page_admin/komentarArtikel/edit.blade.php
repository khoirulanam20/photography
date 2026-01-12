@extends('template_admin.layout')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold py-3 mb-0">
            <span class="text-muted fw-light">Komentar Artikel /</span> Edit Komentar
        </h4>
        <a href="{{ route('komentarArtikel.index') }}" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Form Edit Komentar</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('komentarArtikel.update', $komentarArtikel->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="artikel_id" class="form-label">Artikel</label>
                                    <select class="form-select @error('artikel_id') is-invalid @enderror" 
                                            id="artikel_id" 
                                            name="artikel_id" 
                                            required>
                                        <option value="">Pilih Artikel</option>
                                        @foreach($artikels as $artikel)
                                            <option value="{{ $artikel->id }}" 
                                                {{ $komentarArtikel->artikel_id == $artikel->id ? 'selected' : '' }}>
                                                {{ $artikel->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('artikel_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama_komentar" class="form-label">Nama</label>
                                    <input type="text" 
                                           class="form-control @error('nama_komentar') is-invalid @enderror" 
                                           id="nama_komentar" 
                                           name="nama_komentar" 
                                           value="{{ old('nama_komentar', $komentarArtikel->nama_komentar) }}" 
                                           required>
                                    @error('nama_komentar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email_komentar" class="form-label">Email</label>
                                    <input type="email" 
                                           class="form-control @error('email_komentar') is-invalid @enderror" 
                                           id="email_komentar" 
                                           name="email_komentar" 
                                           value="{{ old('email_komentar', $komentarArtikel->email_komentar) }}" 
                                           required>
                                    @error('email_komentar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="no_hp_komentar" class="form-label">No HP</label>
                                    <input type="text" 
                                           class="form-control @error('no_hp_komentar') is-invalid @enderror" 
                                           id="no_hp_komentar" 
                                           name="no_hp_komentar" 
                                           value="{{ old('no_hp_komentar', $komentarArtikel->no_hp_komentar) }}" 
                                           required>
                                    @error('no_hp_komentar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="komentar" class="form-label">Komentar</label>
                                    <textarea class="form-control @error('komentar') is-invalid @enderror" 
                                              id="komentar" 
                                              name="komentar" 
                                              rows="10" 
                                              required>{{ old('komentar', $komentarArtikel->komentar) }}</textarea>
                                    @error('komentar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('komentarArtikel.index') }}" class="btn btn-secondary">
                                <i class="bx bx-x"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .form-label {
        font-weight: 500;
    }
    .form-control:focus, .form-select:focus {
        border-color: #696cff;
        box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.25);
    }
</style>
@endpush
@endsection 