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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Tentang</a></li>
                                <li class="breadcrumb-item" aria-current="page">Form Edit Data Tentang</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Form Edit Data Tentang</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row justify-content-center">
                <!-- [ form-element ] start -->
                <div class="col-sm-10">
                    <!-- Basic Inputs -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Form Edit Data Tentang</h5>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('tentang.update', $tentang->id) }}" method="POST"
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
                                    @if ($tentang->gambar)
                                        <div class="mt-2">
                                            <label class="form-label">Gambar Saat Ini</label>
                                            <img src="{{ asset('upload/tentang/' . $tentang->gambar) }}"
                                                alt="Gambar {{ $tentang->judul }}" class="img-thumbnail"
                                                style="max-height: 200px;">
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Judul</label>
                                    <input type="text" name="judul"
                                        class="form-control @error('judul') is-invalid @enderror"
                                        value="{{ old('judul', $tentang->judul) }}" placeholder="Masukkan judul" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4"
                                        placeholder="Masukkan deskripsi" required>{{ old('deskripsi', $tentang->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Hitungan (4 bidang angka)</label>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label small">Angka 1</label>
                                            <input type="number" name="hitungan[]"
                                                class="form-control @error('hitungan.0') is-invalid @enderror"
                                                value="{{ old('hitungan.0', $tentang->hitungan[0] ?? '') }}"
                                                placeholder="Masukkan angka 1" required>
                                            @error('hitungan.0')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label small">Angka 2</label>
                                            <input type="number" name="hitungan[]"
                                                class="form-control @error('hitungan.1') is-invalid @enderror"
                                                value="{{ old('hitungan.1', $tentang->hitungan[1] ?? '') }}"
                                                placeholder="Masukkan angka 2" required>
                                            @error('hitungan.1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label small">Angka 3</label>
                                            <input type="number" name="hitungan[]"
                                                class="form-control @error('hitungan.2') is-invalid @enderror"
                                                value="{{ old('hitungan.2', $tentang->hitungan[2] ?? '') }}"
                                                placeholder="Masukkan angka 3" required>
                                            @error('hitungan.2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label small">Angka 4</label>
                                            <input type="number" name="hitungan[]"
                                                class="form-control @error('hitungan.3') is-invalid @enderror"
                                                value="{{ old('hitungan.3', $tentang->hitungan[3] ?? '') }}"
                                                placeholder="Masukkan angka 4" required>
                                            @error('hitungan.3')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Keterangan Hitungan (4 keterangan)</label>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label small">Keterangan 1</label>
                                            <input type="text" name="keterangan_hitungan[]"
                                                class="form-control @error('keterangan_hitungan.0') is-invalid @enderror"
                                                value="{{ old('keterangan_hitungan.0', $tentang->keterangan_hitungan[0] ?? '') }}"
                                                placeholder="Masukkan keterangan 1" required>
                                            @error('keterangan_hitungan.0')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label small">Keterangan 2</label>
                                            <input type="text" name="keterangan_hitungan[]"
                                                class="form-control @error('keterangan_hitungan.1') is-invalid @enderror"
                                                value="{{ old('keterangan_hitungan.1', $tentang->keterangan_hitungan[1] ?? '') }}"
                                                placeholder="Masukkan keterangan 2" required>
                                            @error('keterangan_hitungan.1')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label small">Keterangan 3</label>
                                            <input type="text" name="keterangan_hitungan[]"
                                                class="form-control @error('keterangan_hitungan.2') is-invalid @enderror"
                                                value="{{ old('keterangan_hitungan.2', $tentang->keterangan_hitungan[2] ?? '') }}"
                                                placeholder="Masukkan keterangan 3" required>
                                            @error('keterangan_hitungan.2')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label small">Keterangan 4</label>
                                            <input type="text" name="keterangan_hitungan[]"
                                                class="form-control @error('keterangan_hitungan.3') is-invalid @enderror"
                                                value="{{ old('keterangan_hitungan.3', $tentang->keterangan_hitungan[3] ?? '') }}"
                                                placeholder="Masukkan keterangan 4" required>
                                            @error('keterangan_hitungan.3')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Keterangan Memilih</label>
                                    <textarea name="keterangan_memilih" id="keterangan_memilih"
                                        class="form-control @error('keterangan_memilih') is-invalid @enderror" rows="4"
                                        placeholder="Masukkan keterangan memilih" required>{{ old('keterangan_memilih', $tentang->keterangan_memilih) }}</textarea>
                                    @error('keterangan_memilih')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gambar About</label>
                                    <input type="file" name="gambar_nilai"
                                        class="form-control @error('gambar_nilai') is-invalid @enderror"
                                        accept="image/*">
                                    @error('gambar_nilai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($tentang->gambar_nilai)
                                        <div class="mt-2">
                                            <label class="form-label">Gambar About Saat Ini</label>
                                            <img src="{{ asset('upload/tentang/' . $tentang->gambar_nilai) }}"
                                                alt="Gambar Nilai" class="img-thumbnail" style="max-height: 200px;">
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Keterangan About</label>
                                    <textarea name="keterangan_nilai" id="keterangan_nilai"
                                        class="form-control @error('keterangan_nilai') is-invalid @enderror" rows="4"
                                        placeholder="Masukkan keterangan nilai" required>{{ old('keterangan_nilai', $tentang->keterangan_nilai) }}</textarea>
                                    @error('keterangan_nilai')
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

@section('scripts')
    <script src="{{ asset('admin/assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
    <script>
        let editors = {};

        document.addEventListener('DOMContentLoaded', function() {
            const initEditor = (selector, key) => {
                const el = document.querySelector(selector);
                if (!el) return;

                ClassicEditor.create(el)
                    .then(editorInstance => {
                        editors[key] = editorInstance;
                    })
                    .catch((error) => {
                        console.error(`Error initializing ${key} editor:`, error);
                    });
            };

            initEditor('#deskripsi', 'deskripsi');
            initEditor('#keterangan_memilih', 'keterangan_memilih');
            initEditor('#keterangan_nilai', 'keterangan_nilai');

            const form = document.querySelector('form[action="{{ route('tentang.update', $tentang->id) }}"]');
            if (form) {
                form.addEventListener('submit', function() {
                    Object.keys(editors).forEach((key) => {
                        const textarea = document.getElementById(key);
                        if (textarea) textarea.value = editors[key].getData();
                    });
                });
            }
        });
    </script>
@endsection
