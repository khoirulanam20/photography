@extends('template_admin.layout')

@section('style')
<style>
    .builder-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 15px;
    }
    .section-block {
        position: relative;
        background: white;
        border: 2px dashed #ddd;
        border-radius: 12px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
        overflow: hidden;
    }
    .section-block:hover {
        border-color: #7267EF;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .section-header {
        background: #f1f1f1;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
    }
    .section-title {
        font-weight: 600;
        color: #333;
        margin: 0;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .section-content {
        padding: 20px;
        min-height: 100px;
    }
    .hero-preview {
        height: 250px;
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        position: relative;
        border-radius: 8px;
    }
    .hero-preview::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.4);
        border-radius: 8px;
    }
    .hero-preview-content {
        position: relative;
        z-index: 1;
        padding: 20px;
    }
    .hero-preview h2, .hero-preview h3 {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 5px;
        color: #ffffff !important;
    }
    .hero-preview p {
        font-size: 0.9rem;
        opacity: 0.9;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }
    .stat-item {
        background: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        text-align: center;
    }
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #7267EF;
        display: block;
    }
    .preview-card {
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 15px;
        background: #fff;
    }
    .project-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 10px;
    }
    .project-item {
        aspect-ratio: 1;
        background-size: cover;
        background-position: center;
        border-radius: 6px;
        position: relative;
    }
    .service-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    .service-item {
        padding: 10px;
        background: #f8f9fa;
        border-radius: 6px;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
    }
    .active-actions {
        display: flex;
        gap: 10px;
    }
    .empty-placeholder {
        text-align: center;
        padding: 40px;
        color: #999;
    }
</style>
@endsection

@section('content')
    <section class="pc-container">
        <div class="pc-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard-asisten">Home</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Beranda</a></li>
                                <li class="breadcrumb-item" aria-current="page">Web Builder View</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title d-flex justify-content-between align-items-center">
                                <h1 class="h3 mb-0">Halaman Beranda Builder</h1>
                                @if ($berandas->isEmpty())
                                    <a href="{{ route('beranda.create') }}" class="btn btn-primary">Setup Halaman Beranda</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="builder-container">
                @php $beranda = $berandas->first(); @endphp

                @if ($beranda)
                    <!-- Hero Section -->
                    <div class="section-block">
                        <div class="section-header">
                            <h5 class="section-title"><i class="ti ti-layout-navbar me-2"></i>1. Hero Section (Utama)</h5>
                            <div class="active-actions">
                                <button type="button" class="btn btn-sm btn-light-warning" data-bs-toggle="modal" data-bs-target="#modalHero">
                                    <i class="ti ti-edit"></i> Edit Hero
                                </button>
                            </div>
                        </div>
                        <div class="section-content">
                            <div class="hero-preview" style="background-image: url('{{ asset('upload/beranda/' . $beranda->gambar_utama) }}')">
                                <div class="hero-preview-content">
                                    <h2>{{ $beranda->judul_utama }}</h2>
                                    <p>{{ $beranda->slogan }}</p>
                                    <button class="btn btn-sm btn-light disabled">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- About Preview -->
                    <div class="section-block">
                        <div class="section-header">
                            <h5 class="section-title"><i class="ti ti-info-circle me-2"></i>2. About Section Preview</h5>
                            <a href="{{ route('tentang.index') }}" class="btn btn-sm btn-light-primary"><i class="ti ti-external-link"></i> Manage About</a>
                        </div>
                        <div class="section-content">
                            @if($tentang)
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h4 class="h5">{{ $tentang->judul }}</h4>
                                        <div class="text-muted" style="font-size: 0.85rem; line-height: 1.5;">
                                            {!! Str::limit($tentang->deskripsi, 250) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <img src="{{ asset('upload/tentang/' . $tentang->gambar) }}" class="img-fluid rounded shadow-sm" alt="About">
                                    </div>
                                </div>
                            @else
                                <p class="text-center text-muted py-3">Data Tentang belum dikonfigurasi.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Statistics Section -->
                    <div class="section-block">
                        <div class="section-header">
                            <h5 class="section-title"><i class="ti ti-chart-bar me-2"></i>3. Statistics Section</h5>
                            <small class="text-muted">Data otomatis dari Tentang Kami</small>
                        </div>
                        <div class="section-content">
                            <div class="stats-grid">
                                @if($tentang && is_array($tentang->hitungan))
                                    @foreach($tentang->hitungan as $idx => $val)
                                        <div class="stat-item">
                                            <span class="stat-value">{{ $val }}</span>
                                            <span class="text-muted small">{{ $tentang->keterangan_hitungan[$idx] ?? '' }}</span>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="stat-item">
                                        <span class="stat-value">25</span>
                                        <span class="text-muted small">Managers</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-value">200</span>
                                        <span class="text-muted small">Members</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-value">15</span>
                                        <span class="text-muted small">Years</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-value">7</span>
                                        <span class="text-muted small">Awards</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Project Preview -->
                    <div class="section-block">
                        <div class="section-header">
                            <h5 class="section-title"><i class="ti ti-folders me-2"></i>4. Project Preview (Carousel)</h5>
                            <a href="{{ route('galeri.index') }}" class="btn btn-sm btn-light-primary"><i class="ti ti-external-link"></i> Manage Projects</a>
                        </div>
                        <div class="section-content">
                            <div class="project-grid">
                                @forelse($projects as $project)
                                    <div class="project-item" style="background-image: url('{{ asset('upload/galeri/' . $project->gambar) }}')">
                                        <div class="position-absolute bottom-0 start-0 w-100 p-2 bg-dark bg-opacity-50 text-white rounded-bottom" style="font-size: 0.7rem;">
                                            {{ Str::limit($project->judul, 15) }}
                                        </div>
                                    </div>
                                @empty
                                    @for($i=0; $i<4; $i++)
                                        <div class="project-item bg-light border d-flex align-items-center justify-content-center">
                                            <i class="ti ti-photo text-muted opacity-50"></i>
                                        </div>
                                    @endfor
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Services Preview -->
                    <div class="section-block">
                        <div class="section-header">
                            <h5 class="section-title"><i class="ti ti-settings me-2"></i>5. Our Services Preview</h5>
                            <a href="{{ route('layanan.index') }}" class="btn btn-sm btn-light-primary"><i class="ti ti-external-link"></i> Manage Services</a>
                        </div>
                        <div class="section-content">
                            <div class="service-list">
                                @forelse($services as $service)
                                    <div class="service-item">
                                        <i class="ti ti-circle-check-filled me-2 text-primary"></i>
                                        {{ $service->judul }}
                                    </div>
                                @empty
                                    <p class="text-muted">Belum ada layanan yang ditambahkan.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Secondary Hero Section -->
                    <div class="section-block">
                        <div class="section-header">
                            <h5 class="section-title"><i class="ti ti-layout-bottombar me-2"></i>6. Secondary Banner Section</h5>
                            <div class="active-actions">
                                <button type="button" class="btn btn-sm btn-light-warning" data-bs-toggle="modal" data-bs-target="#modalSecondary">
                                    <i class="ti ti-edit"></i> Edit Slogan
                                </button>
                            </div>
                        </div>
                        <div class="section-content">
                            <div class="hero-preview" style="background-image: url('{{ asset('upload/beranda/' . $beranda->gambar_sekunder) }}'); height: 160px;">
                                <div class="hero-preview-content">
                                    <h3>{{ $beranda->judul_sekunder }}</h3>
                                    <p style="font-size: 0.85rem;">{{ $beranda->keterangan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modals for Editing -->
                    <!-- Modal Hero -->
                    <div class="modal fade" id="modalHero" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="{{ route('beranda.update', $beranda->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="judul_sekunder" value="{{ $beranda->judul_sekunder }}">
                                <input type="hidden" name="keterangan" value="{{ $beranda->keterangan }}">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Hero Section</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Judul Utama</label>
                                                <input type="text" name="judul_utama" class="form-control" value="{{ $beranda->judul_utama }}" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Slogan Hero</label>
                                                <input type="text" name="slogan" class="form-control" value="{{ $beranda->slogan }}" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Ganti Gambar Utama</label>
                                                <input type="file" name="gambar_utama" class="form-control" accept="image/*">
                                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Secondary -->
                    <div class="modal fade" id="modalSecondary" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="{{ route('beranda.update', $beranda->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="judul_utama" value="{{ $beranda->judul_utama }}">
                                <input type="hidden" name="slogan" value="{{ $beranda->slogan }}">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Secondary Banner</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Judul Sekunder</label>
                                                <input type="text" name="judul_sekunder" class="form-control" value="{{ $beranda->judul_sekunder }}" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Keterangan / Slogan Bawah</label>
                                                <textarea name="keterangan" class="form-control" rows="3" required>{{ $beranda->keterangan }}</textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label">Ganti Gambar Sekunder</label>
                                                <input type="file" name="gambar_sekunder" class="form-control" accept="image/*">
                                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                @else
                    <div class="card">
                        <div class="card-body empty-placeholder">
                            <i class="ti ti-layout-off" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Belum ada konfigurasi Beranda</h4>
                            <p>Silahkan klik tombol "Setup Halaman Beranda" untuk memulai.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
