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
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.booking.show', $booking->id) }}">Detail Booking
                                        #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Edit Booking
                                    #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h2 class="mb-0">
                                    <i class="fas fa-exclamation-circle me-2"></i>Update Informasi Booking
                                    #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.booking.update', $booking->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Pemesan</label>
                                            <input type="text" name="nama"
                                                class="form-control @error('nama') is-invalid @enderror"
                                                value="{{ old('nama', $booking->nama) }}" placeholder="Nama Pemesan">
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tanggal Booking</label>
                                            <input type="date" name="booking_date"
                                                class="form-control @error('booking_date') is-invalid @enderror"
                                                value="{{ old('booking_date', $booking->booking_date->format('Y-m-d')) }}">
                                            @error('booking_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Paket</label>
                                            <select name="layanan_id" id="layanan_id"
                                                class="form-control @error('layanan_id') is-invalid @enderror">
                                                <option value="">Pilih Paket</option>
                                                @foreach (\App\Models\Layanan::all() as $layanan)
                                                    <option value="{{ $layanan->id }}"
                                                        {{ old('layanan_id', $booking->layanan_id) == $layanan->id ? 'selected' : '' }}>
                                                        {{ $layanan->judul }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('layanan_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Sub Paket</label>
                                            <select name="sub_layanan_id" id="sub_layanan_id"
                                                class="form-control @error('sub_layanan_id') is-invalid @enderror">
                                                <option value="">Pilih Sub Paket</option>
                                                @if ($booking->subLayanan)
                                                    <option value="{{ $booking->subLayanan->id }}" selected>
                                                        {{ $booking->subLayanan->judul }}
                                                    </option>
                                                @endif
                                            </select>
                                            @error('sub_layanan_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Area</label>
                                            <input type="text" name="area"
                                                class="form-control @error('area') is-invalid @enderror"
                                                value="{{ old('area', $booking->area) }}" placeholder="Area">
                                            @error('area')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Fotografer</label>
                                            <select name="fotografer"
                                                class="form-control @error('fotografer') is-invalid @enderror">
                                                <option value="">Pilih Fotografer</option>
                                                @foreach (\App\Models\Tim::all() as $tim)
                                                    <option value="{{ $tim->nama }}"
                                                        {{ old('fotografer', $booking->fotografer) == $tim->nama ? 'selected' : '' }}>
                                                        {{ $tim->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('fotografer')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Telepon</label>
                                            <input type="text" name="telephone"
                                                class="form-control @error('telephone') is-invalid @enderror"
                                                value="{{ old('telephone', $booking->telephone) }}" placeholder="Telepon">
                                            @error('telephone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Instagram</label>
                                            <input type="text" name="instagram"
                                                class="form-control @error('instagram') is-invalid @enderror"
                                                value="{{ old('instagram', $booking->instagram) }}"
                                                placeholder="Instagram">
                                            @error('instagram')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Waktu Booking</label>
                                            <input type="time" name="booking_time"
                                                class="form-control @error('booking_time') is-invalid @enderror"
                                                value="{{ old('booking_time', $booking->booking_time) }}"
                                                placeholder="Waktu">
                                            @error('booking_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Biaya</label>
                                            <input type="text" name="biaya"
                                                class="form-control @error('biaya') is-invalid @enderror"
                                                value="{{ old('biaya', $booking->biaya) }}" placeholder="Contoh: 500000">
                                            @error('biaya')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Lokasi</label>
                                            <input type="text" name="lokasi_photo"
                                                class="form-control @error('lokasi_photo') is-invalid @enderror"
                                                value="{{ old('lokasi_photo', $booking->lokasi_photo) }}"
                                                placeholder="Lokasi">
                                            @error('lokasi_photo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status"
                                                class="form-control @error('status') is-invalid @enderror" required>
                                                <option value="Pending"
                                                    {{ $booking->status == 'Pending' ? 'selected' : '' }}>
                                                    Pending
                                                </option>
                                                <option value="Ditolak"
                                                    {{ $booking->status == 'Ditolak' ? 'selected' : '' }}>
                                                    Ditolak
                                                </option>
                                                <option value="Diterima"
                                                    {{ $booking->status == 'Diterima' ? 'selected' : '' }}>
                                                    Diterima
                                                </option>
                                                <option value="Diproses"
                                                    {{ $booking->status == 'Diproses' ? 'selected' : '' }}>
                                                    Diproses
                                                </option>
                                                <option value="Selesai"
                                                    {{ $booking->status == 'Selesai' ? 'selected' : '' }}>
                                                    Selesai
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Tambah Catatan (Opsional)</label>
                                            <textarea name="catatan_baru" rows="3" class="form-control @error('catatan_baru') is-invalid @enderror"
                                                placeholder="Masukkan catatan baru..."></textarea>
                                            @error('catatan_baru')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle me-1"></i>Catatan akan otomatis terhubung
                                                dengan
                                                status yang dipilih
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Riwayat Catatan</label>
                                            <div class="card bg-light border">
                                                <div class="card-header bg-transparent border-0 py-2">
                                                    <h6 class="mb-0">
                                                        <i class="fas fa-history text-primary me-2"></i>
                                                        <strong>Riwayat Catatan</strong>
                                                    </h6>
                                                </div>
                                                <div class="card-body py-2" style="max-height: 250px; overflow-y: auto;">
                                                    @if (is_array($booking->catatan) && count($booking->catatan) > 0)
                                                        @foreach (array_reverse($booking->catatan) as $index => $item)
                                                            <div class="border-start border-3 ps-3 mb-3 pb-2"
                                                                style="background-color: #f8f9fa;
                                                                border-color:
                                                                @if ($item['status'] == 'Pending') #ffc107
                                                                @elseif($item['status'] == 'Ditolak') #dc3545
                                                                @elseif($item['status'] == 'Diterima') #0dcaf0
                                                                @elseif($item['status'] == 'Diproses') #0d6efd
                                                                @elseif($item['status'] == 'Selesai') #198754
                                                                @else #6c757d @endif;">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-start mb-1">
                                                                    <div>
                                                                        <span
                                                                            class="badge
                                                                            @if ($item['status'] == 'Pending') bg-warning
                                                                            @elseif($item['status'] == 'Ditolak') bg-danger
                                                                            @elseif($item['status'] == 'Diterima') bg-info
                                                                            @elseif($item['status'] == 'Diproses') bg-primary
                                                                            @elseif($item['status'] == 'Selesai') bg-success
                                                                            @else bg-secondary @endif
                                                                            text-white me-2">
                                                                            {{ $item['status'] ?? '' }}
                                                                        </span>
                                                                        <small class="text-muted">
                                                                            <i
                                                                                class="fas fa-calendar me-1"></i>{{ $item['tanggal'] ?? '' }}
                                                                            <i
                                                                                class="fas fa-clock ms-2 me-1"></i>{{ $item['waktu'] ?? '' }}
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                <p class="mb-0 mt-2"
                                                                    style="line-height: 1.6; white-space: pre-wrap; font-size: 0.9rem;">
                                                                    {{ $item['isi'] ?? '' }}</p>
                                                            </div>
                                                        @endforeach
                                                    @elseif (is_string($booking->catatan) && $booking->catatan)
                                                        <div class="alert alert-info alert-sm mb-2" role="alert">
                                                            <strong><i class="fas fa-sticky-note me-2"></i>Catatan
                                                                Lama:</strong>
                                                            <p class="mb-0 mt-1" style="white-space: pre-wrap;">
                                                                {{ $booking->catatan }}</p>
                                                        </div>
                                                    @else
                                                        <p class="text-muted mb-0 text-center py-3"><em><i
                                                                    class="fas fa-inbox me-2"></i>Belum ada
                                                                catatan</em></p>
                                                    @endif
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle me-1"></i>Riwayat catatan akan bertambah
                                                setiap
                                                kali Anda menambahkan catatan baru
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-end mt-4">
                                    <a href="{{ route('admin.booking.show', $booking->id) }}"
                                        class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Simpan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const layananSelect = document.getElementById('layanan_id');
            const subLayananSelect = document.getElementById('sub_layanan_id');

            function loadSubLayanans(layananId) {
                const firstOption = subLayananSelect.querySelector('option[value=""]');
                subLayananSelect.innerHTML = '';
                if (firstOption) {
                    subLayananSelect.appendChild(firstOption);
                }

                if (layananId) {
                    fetch(`/api/sub-layanan/${layananId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(function(subLayanan) {
                                const option = document.createElement('option');
                                option.value = subLayanan.id;
                                option.textContent = subLayanan.judul;

                                @if ($booking->subLayanan)
                                    if (subLayanan.id == {{ $booking->sub_layanan_id }}) {
                                        option.selected = true;
                                    }
                                @endif

                                subLayananSelect.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            }

            const currentLayananId = layananSelect.value;
            if (currentLayananId) {
                loadSubLayanans(currentLayananId);
            }

            layananSelect.addEventListener('change', function() {
                loadSubLayanans(this.value);
            });
        });
    </script>
@endsection
