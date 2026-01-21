@extends('template_admin.layout')

@section('style')
<style>
    .builder-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        background: #f4f7fb;
        border-radius: 15px;
    }
    .section-block {
        position: relative;
        background: white;
        border: 1px solid #e3e6f0;
        border-radius: 12px;
        margin-bottom: 30px;
        transition: all 0.3s ease;
        overflow: hidden;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 120, 0.05);
    }
    .section-block:hover {
        border-color: #4e73df;
        transform: translateY(-2px);
    }
    .section-header {
        background: #f8f9fc;
        padding: 12px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e3e6f0;
    }
    .section-title {
        font-weight: 700;
        color: #4e73df;
        margin: 0;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .section-content {
        padding: 25px;
    }
    .banner-preview {
        height: 200px;
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        color: white;
        text-align: center;
    }
    .banner-preview::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.4);
        border-radius: 10px;
    }
    .banner-text h2 {
        color: #ffffff !important;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }
    .team-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }
    .team-item {
        text-align: center;
        background: #f8f9fc;
        padding: 15px;
        border-radius: 10px;
    }
    .team-item img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 10px;
        border: 2px solid #4e73df;
    }
    .team-name {
        font-weight: 700;
        font-size: 0.85rem;
        display: block;
    }
    .team-pos {
        font-size: 0.75rem;
        color: #858796;
    }
    .service-preview-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    .service-preview-item {
        display: flex;
        align-items: center;
        padding: 12px;
        background: #f8f9fc;
        border-radius: 8px;
        border-left: 3px solid #4e73df;
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
                                <li class="breadcrumb-item"><a href="javascript: void(0)">Tentang</a></li>
                                <li class="breadcrumb-item" aria-current="page">Web Builder View</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title d-flex justify-content-between align-items-center">
                                <h1 class="h3 mb-0">Halaman Tentang Builder</h1>
                                @if (!$tentang || $tentang->count() == 0)
                                    <a href="{{ route('tentang.create') }}" class="btn btn-primary"><i class="ti ti-plus me-1"></i> Setup Page</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="ti ti-check me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="builder-container">
                @php $item = $tentang->first(); @endphp

                @if ($item)
                    <!-- Section 1: Main Banner -->
                    <div class="section-block">
                        <div class="section-header">
                            <h5 class="section-title"><i class="ti ti-photo me-2"></i>1. Main Banner Section</h5>
                            <div class="builder-actions">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalBanner">
                                    <i class="ti ti-edit"></i> Edit Banner
                                </button>
                            </div>
                        </div>
                        <div class="section-content">
                            <div class="banner-preview" style="background-image: url('{{ asset('upload/tentang/' . $item->gambar) }}')">
                                <div class="banner-text">
                                    <h2 class="h2 font-weight-bold">{{ $item->judul }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Story & Experience (Matches Web about-video-section) -->
                    <div class="section-block">
                        <div class="section-header">
                            <h5 class="section-title"><i class="ti ti-file-description me-2"></i>2. Our Story & Experience</h5>
                            <div class="builder-actions">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalStory">
                                    <i class="ti ti-edit"></i> Edit Konten & Statistik
                                </button>
                            </div>
                        </div>
                        <div class="section-content">
                            <div class="row mb-4">
                                <div class="col-md-7">
                                    <div class="web-style-title mb-4" style="font-size: 1.5rem; font-weight: 700; line-height: 1.2; color: #333;">
                                        {{ $item->judul }}
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <div class="border-top pt-2">
                                                <small class="text-uppercase fw-bold text-muted" style="letter-spacing: 1px;">About Us</small>
                                                <div class="mt-1"><i class="ti ti-arrow-right text-primary"></i></div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="text-muted" style="font-size: 0.85rem; line-height: 1.6;">
                                                {!! $item->deskripsi !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="position-relative">
                                        <img src="{{ asset('upload/tentang/' . ($item->gambar_nilai ?? $item->gambar)) }}" class="img-fluid rounded shadow-sm" style="width: 100%; height: 200px; object-fit: cover;" alt="Experience Image">
                                        <div class="position-absolute shadow-lg" style="bottom: -10px; right: -10px; background: #fff; padding: 10px; border-radius: 5px;">
                                            <i class="ti ti-player-play-filled text-primary" style="font-size: 1.5rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="stats-row mt-5 border-top pt-4" style="display: flex; justify-content: space-around; background: #f8f9fc; padding: 20px; border-radius: 10px;">
                                @php
                                    $hitungan = is_array($item->hitungan) ? $item->hitungan : json_decode($item->hitungan, true);
                                    $keterangan = is_array($item->keterangan_hitungan) ? $item->keterangan_hitungan : json_decode($item->keterangan_hitungan, true);
                                @endphp
                                @if($hitungan)
                                    @foreach($hitungan as $idx => $val)
                                        <div class="stat-box" style="text-align: center;">
                                            <span class="stat-num" style="display: block; font-size: 1.8rem; font-weight: 800; color: #4e73df;">{{ $val }}</span>
                                            <span class="stat-label" style="font-size: 0.65rem; color: #858796; text-transform: uppercase;">{!! nl2br(e($keterangan[$idx] ?? '')) !!}</span>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Services Preview -->
                    <div class="section-block">
                        <div class="section-header">
                            <h5 class="section-title"><i class="ti ti-settings me-2"></i>4. Our Services Preview</h5>
                            <a href="{{ route('layanan.index') }}" class="btn btn-sm btn-outline-primary">
                                <i class="ti ti-external-link"></i> Manage Services
                            </a>
                        </div>
                        <div class="section-content">
                            <div class="service-preview-list">
                                @forelse($services->take(4) as $service)
                                    <div class="service-preview-item">
                                        <i class="ti ti-circle-check-filled me-2 text-primary"></i>
                                        <span style="font-size: 0.85rem;">{{ $service->judul }}</span>
                                    </div>
                                @empty
                                    <div class="col-12 py-3 text-center text-muted">Belum ada layanan.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Section 5: Values & Mission -->
                    <div class="section-block">
                        <div class="section-header">
                            <h5 class="section-title"><i class="ti ti-bulb me-2"></i>5. Values & Mission Details</h5>
                            <div class="builder-actions">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalValues">
                                    <i class="ti ti-edit"></i> Edit Detail
                                </button>
                            </div>
                        </div>
                        <div class="section-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-muted"><i class="ti ti-quote me-2"></i>{!! $item->keterangan_nilai !!}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modals for Editing -->
                    <!-- Modal Banner -->
                    <div class="modal fade" id="modalBanner" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('tentang.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="deskripsi" value="{{ $item->deskripsi }}">
                                <input type="hidden" name="keterangan_memilih" value="{{ $item->keterangan_memilih }}">
                                <input type="hidden" name="keterangan_nilai" value="{{ $item->keterangan_nilai }}">
                                @foreach($item->hitungan as $h) <input type="hidden" name="hitungan[]" value="{{ $h }}"> @endforeach
                                @foreach($item->keterangan_hitungan as $k) <input type="hidden" name="keterangan_hitungan[]" value="{{ $k }}"> @endforeach

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Main Banner</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Judul Halaman</label>
                                            <input type="text" name="judul" class="form-control" value="{{ $item->judul }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ganti Gambar Banner</label>
                                            <input type="file" name="gambar" class="form-control" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Story & Stats -->
                    <div class="modal fade" id="modalStory" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <form action="{{ route('tentang.update', $item->id) }}" method="POST" enctype="multipart/form-data" id="formStory">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="judul" value="{{ $item->judul }}">
                                <input type="hidden" name="keterangan_memilih" value="{{ $item->keterangan_memilih }}">
                                <input type="hidden" name="keterangan_nilai" value="{{ $item->keterangan_nilai }}">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Story & Statistics</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi Perusahaan</label>
                                                    <textarea name="deskripsi" id="editorDeskripsi" class="form-control">{{ $item->deskripsi }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Gambar Pendukung (About)</label>
                                                    <input type="file" name="gambar_nilai" class="form-control" accept="image/*">
                                                </div>
                                                <h6 class="mt-4 mb-3 border-bottom pb-2">Data Statistik</h6>
                                                @for($i=0; $i<4; $i++)
                                                <div class="row g-2 mb-2">
                                                    <div class="col-4">
                                                        <input type="number" name="hitungan[]" class="form-control" placeholder="Angka" value="{{ $item->hitungan[$i] ?? '' }}" required>
                                                    </div>
                                                    <div class="col-8">
                                                        <input type="text" name="keterangan_hitungan[]" class="form-control" placeholder="Keterangan" value="{{ $item->keterangan_hitungan[$i] ?? '' }}" required>
                                                    </div>
                                                </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Semua Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Modal Values -->
                    <div class="modal fade" id="modalValues" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="{{ route('tentang.update', $item->id) }}" method="POST" enctype="multipart/form-data" id="formValues">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="judul" value="{{ $item->judul }}">
                                <input type="hidden" name="deskripsi" value="{{ $item->deskripsi }}">
                                <input type="hidden" name="keterangan_memilih" value="{{ $item->keterangan_memilih }}">
                                @foreach($item->hitungan as $h) <input type="hidden" name="hitungan[]" value="{{ $h }}"> @endforeach
                                @foreach($item->keterangan_hitungan as $k) <input type="hidden" name="keterangan_hitungan[]" value="{{ $k }}"> @endforeach

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Values & Mission</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Keterangan Nilai / Misi</label>
                                            <textarea name="keterangan_nilai" id="editorValues" class="form-control">{{ $item->keterangan_nilai }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                @else
                    <div class="empty-state">
                        <i class="ti ti-layout-2 mb-3" style="font-size: 4rem; color: #e3e6f0;"></i>
                        <h3>No Content Found</h3>
                        <p class="text-muted">You haven't initialized the About page content yet.</p>
                        <a href="{{ route('tentang.create') }}" class="btn btn-primary mt-2">Setup "About Us" Page</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('script')
<script src="{{ asset('admin/assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
<script>
    let editors = {};

    function initCKEditor(id) {
        if (!document.querySelector('#' + id)) return;
        ClassicEditor.create(document.querySelector('#' + id))
            .then(editor => {
                editors[id] = editor;
            })
            .catch(error => {
                console.error(error);
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initCKEditor('editorDeskripsi');
        initCKEditor('editorValues');

        // Sync data before submit
        ['formStory', 'formValues'].forEach(formId => {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', function() {
                    Object.keys(editors).forEach(id => {
                        const textarea = document.getElementById(id);
                        if (textarea) textarea.value = editors[id].getData();
                    });
                });
            }
        });
    });
</script>
@endsection
