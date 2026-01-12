@extends('template_admin.layout')

@section('content')
    <section class="pc-container">
        <div class="pc-content">
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/dashboard-asisten">Home</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.booking.index') }}">Booking</a></li>
                                <li class="breadcrumb-item" aria-current="page">Detail Booking
                                    #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">Detail Booking #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .form-check-input:checked {
                    background-color: #28a745 !important;
                    border-color: #28a745 !important;
                }

                .form-check-input:focus {
                    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
                    border-color: #28a745;
                }
            </style>
            <div class="row">
                <div class="col-sm-12">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        Status Booking ID{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }} |
                                        @if ($booking->status == 'Pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($booking->status == 'Ditolak')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($booking->status == 'Diterima')
                                            <span class="badge bg-info">Diterima</span>
                                        @elseif($booking->status == 'Diproses')
                                            <span class="badge bg-primary">Diproses</span>
                                        @elseif($booking->status == 'Selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($booking->status == 'Dibatalkan')
                                            <span class="badge bg-secondary">Dibatalkan</span>
                                        @endif
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <strong>Nama Pemesan:</strong> {{ $booking->nama }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Alamat:</strong> {{ $booking->area }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Telepon:</strong> {{ $booking->telephone }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Instagram:</strong> {{ $booking->instagram ?? '-' }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Tanggal Booking:</strong>
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $booking->booking_date->format('l d F Y') }}
                                        <i class="fas fa-clock ms-2 me-1"></i>
                                        {{ date('H.i', strtotime($booking->booking_time)) }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Catatan:</strong>
                                        @if ($booking->catatan && is_array($booking->catatan) && count($booking->catatan) > 0)
                                            <a href="#" class="ms-2" data-bs-toggle="modal"
                                                data-bs-target="#riwayatCatatanModal"
                                                title="Lihat Riwayat Catatan ({{ count($booking->catatan) }})">
                                                <i class="fas fa-history"></i>
                                            </a>
                                        @else
                                            <span class="text-muted ms-2">-</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        Informasi Booking
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <strong>Paket Foto:</strong> {{ $booking->layanan->judul ?? '-' }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Area:</strong> {{ $booking->area }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Lokasi:</strong> {{ $booking->lokasi_photo }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Biaya:</strong> Rp {{ $booking->biaya ?? '-' }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Fotografer:</strong> {{ $booking->fotografer ?? '-' }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Detail Paket:</strong>
                                        {{ $booking->layanan && $booking->layanan->deskripsi ? strip_tags($booking->layanan->deskripsi) : '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-sync-alt me-2"></i>
                                        Alur Progress Booking
                                    </h5>
                                </div>
                                <div class="card-body">
                                    @if ($booking->progress)
                                        <div id="progress-form" data-booking-id="{{ $booking->id }}">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input progress-checkbox" type="checkbox"
                                                    data-field="jadwal_foto" id="jadwal_foto"
                                                    {{ $booking->progress->jadwal_foto ? 'checked' : '' }}>
                                                <label class="form-check-label" for="jadwal_foto">
                                                    Jadwal Foto Sudah Terpesan
                                                </label>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input progress-checkbox" type="checkbox"
                                                    data-field="file_jpg_upload" id="file_jpg_upload"
                                                    {{ $booking->progress->file_jpg_upload ? 'checked' : '' }}
                                                    {{ empty($booking->progress->file_jpg_link) ? 'disabled' : '' }}>
                                                <label class="form-check-label" for="file_jpg_upload">
                                                    File JPG Upload
                                                </label>
                                            </div>
                                            <div class="mb-3 ms-4">
                                                <label for="google_drive_link" class="form-label small">Link Google
                                                    Drive</label>
                                                <input type="url" class="form-control form-control-sm progress-link"
                                                    id="google_drive_link" data-field="file_jpg_upload"
                                                    value="{{ $booking->progress->file_jpg_link ?? '' }}"
                                                    placeholder="Masukkan link Google Drive">
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input progress-checkbox" type="checkbox"
                                                    data-field="selected_photos" id="selected_photos"
                                                    {{ $booking->progress->selected_photos ? 'checked' : '' }}>
                                                <label class="form-check-label" for="selected_photos">
                                                    Pilih Kode Foto
                                                    @if ($booking->progress->selected_photos_link)
                                                        <a href="#" class="ms-2" data-bs-toggle="modal"
                                                            data-bs-target="#selectedPhotosModal"
                                                            title="Lihat Selected Photos">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif
                                                </label>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input progress-checkbox" type="checkbox"
                                                    data-field="editing_foto" id="editing_foto"
                                                    {{ $booking->progress->editing_foto ? 'checked' : '' }}>
                                                <label class="form-check-label" for="editing_foto">
                                                    Dalam Proses Editing
                                                </label>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input class="form-check-input progress-checkbox" type="checkbox"
                                                    data-field="foto_edited_upload" id="foto_edited_upload"
                                                    {{ $booking->progress->foto_edited_upload ? 'checked' : '' }}
                                                    {{ empty($booking->progress->foto_edited_upload_link) ? 'disabled' : '' }}>
                                                <label class="form-check-label" for="foto_edited_upload">
                                                    Foto Edited Upload
                                                </label>
                                            </div>
                                            <div class="mb-3 ms-4">
                                                <label for="foto_edited_upload_link" class="form-label small">Link Google
                                                    Drive Edited</label>
                                                <input type="url" class="form-control form-control-sm progress-link"
                                                    id="foto_edited_upload_link" data-field="foto_edited_upload"
                                                    value="{{ $booking->progress->foto_edited_upload_link ?? '' }}"
                                                    placeholder="Masukkan link Google Drive untuk foto edited">
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            Progress akan otomatis dibuat saat status booking diubah ke "Diproses"
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">
                                        <i class="fas fa-mouse-pointer me-2"></i>
                                        Tindakan
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#updateStatusModal" data-booking-id="{{ $booking->id }}">
                                            <i class="fas fa-edit"></i> Update Status
                                        </button>

                                        <a href="{{ route('admin.booking.edit', $booking->id) }}"
                                            class="btn btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit Pesanan
                                        </a>

                                        @if ($booking->hasPayments())
                                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                                data-bs-target="#paymentModal" data-booking-id="{{ $booking->id }}">
                                                <i class="fas fa-check"></i> Lihat Pembayaran
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary" disabled>
                                                <i class="fas fa-times"></i> Belum Ada Pembayaran
                                            </button>
                                        @endif

                                        <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger w-100"
                                                onclick="return confirm('Yakin ingin menghapus pesanan?')">
                                                <i class="fas fa-trash"></i> Hapus Pesanan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('page_admin.booking.modal.update_status')

    @include('page_admin.booking.modal.riwayat_catatan')

    @include('page_admin.booking.modal.selected_photos')

    @include('page_admin.booking.modal.payment')
@endsection

@section('script')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookingId = document.getElementById('progress-form')?.dataset.bookingId;
            if (!bookingId) return;

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                '{{ csrf_token() }}';

            function syncCheckboxWithLink(linkInputId, checkboxId) {
                const inputEl = document.getElementById(linkInputId);
                const checkboxEl = document.getElementById(checkboxId);
                if (!inputEl || !checkboxEl) return;
                const hasLink = inputEl.value.trim().length > 0;
                checkboxEl.disabled = !hasLink;
            }

            syncCheckboxWithLink('google_drive_link', 'file_jpg_upload');
            syncCheckboxWithLink('foto_edited_upload_link', 'foto_edited_upload');

            document.querySelectorAll('.progress-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const field = this.dataset.field;
                    const value = this.checked ? 1 : 0;

                    if (field === 'file_jpg_upload' && value === 1) {
                        const link = document.getElementById('google_drive_link')?.value?.trim() ||
                            '';
                        if (!link) {
                            this.checked = false;
                            Swal.fire({
                                icon: 'info',
                                title: 'Lengkapi Link Dulu',
                                text: 'Isi link Google Drive terlebih dahulu sebelum mencentang.'
                            });
                            return;
                        }
                        updateProgress(field, value, link);
                        return;
                    }

                    if (field === 'foto_edited_upload' && value === 1) {
                        const link = document.getElementById('foto_edited_upload_link')?.value
                            ?.trim() || '';
                        if (!link) {
                            this.checked = false;
                            Swal.fire({
                                icon: 'info',
                                title: 'Lengkapi Link Dulu',
                                text: 'Isi link Google Drive Edited terlebih dahulu sebelum mencentang.'
                            });
                            return;
                        }
                        updateProgress(field, value, link);
                        return;
                    }

                    updateProgress(field, value, null);
                });

                checkbox.addEventListener('click', function(e) {
                    if (this.disabled) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'info',
                            title: 'Lengkapi Link Dulu',
                            text: 'Isi link Google Drive terlebih dahulu sebelum mencentang.'
                        });
                    }
                });
            });

            document.querySelectorAll('.progress-link').forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.id === 'google_drive_link') {
                        syncCheckboxWithLink('google_drive_link', 'file_jpg_upload');
                    }
                    if (this.id === 'foto_edited_upload_link') {
                        syncCheckboxWithLink('foto_edited_upload_link', 'foto_edited_upload');
                    }
                });
            });

            function updateProgress(field, value, link) {
                const formData = new FormData();
                formData.append('field', field);
                formData.append('value', value);
                if (link !== null) {
                    formData.append('link', link);
                }

                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(`/super-admin/booking/${bookingId}/progress/quick`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message + (data.whatsapp_sent ?
                                    ' Notifikasi WhatsApp telah dikirim ke client.' : ''),
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message || 'Terjadi kesalahan saat menyimpan progress'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menyimpan progress: ' + error.message
                        });
                    });
            }
        });
    </script>
@endsection
