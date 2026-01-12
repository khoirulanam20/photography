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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Testimoni</a></li>
                                <li class="breadcrumb-item" aria-current="page">Form Edit Data Testimoni</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Form Edit Data Testimoni</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row justify-content-center">
                <!-- [ form-element ] start -->
                <div class="col-sm-6">
                    <!-- Basic Inputs -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Form Edit Data Testimoni</h5>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('testimoni.update', $testimoni->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="form-label">Gambar</label>
                                    <input type="file" name="gambar"
                                        class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($testimoni->gambar)
                                        <div class="mt-2">
                                            <label class="form-label">Gambar Saat Ini</label>
                                            <img src="{{ asset('upload/testimoni/' . $testimoni->gambar) }}"
                                                alt="Gambar {{ $testimoni->nama }}" class="img-thumbnail"
                                                style="max-height: 200px;">
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Nama</label>
                                    <input type="text" name="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        value="{{ old('nama', $testimoni->nama) }}" placeholder="Masukkan nama" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" name="jabatan"
                                        class="form-control @error('jabatan') is-invalid @enderror"
                                        value="{{ old('jabatan', $testimoni->jabatan) }}" placeholder="Masukkan jabatan"
                                        required>
                                    @error('jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Testimoni</label>
                                    <textarea name="testimoni" class="form-control @error('testimoni') is-invalid @enderror" rows="4"
                                        placeholder="Masukkan testimoni" required>{{ old('testimoni', $testimoni->testimoni) }}</textarea>
                                    @error('testimoni')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Rating</label>
                                    <input type="number" name="rating"
                                        class="form-control @error('rating') is-invalid @enderror"
                                        value="{{ old('rating', $testimoni->rating) }}" placeholder="Masukkan rating (1-5)"
                                        min="1" max="5" required>
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                    <button type="button" class="btn btn-light" onclick="history.back()">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
