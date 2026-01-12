@extends('template_web.layout')
@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="{{ asset('css/booking-form.css') }}">
@endsection
@section('content')
    <main>
        <section class="booking-section">
            <div class="booking-container">
                <div class="booking-form-container">
                    <h1 class="form-title">Create Booking</h1>
                    <form class="booking-form" id="bookingForm" action="{{ route('booking.store') }}" method="POST">
                        @csrf

                        <div class="form-row">
                            <div class="field">
                                <input type="text" id="nama" name="nama" value="{{ old('nama', $user->name) }}"
                                    placeholder=" " required>
                                <label for="nama" class="field__hint">
                                    <ion-icon name="person-outline"></ion-icon>
                                    Nama *
                                </label>
                                @error('nama')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <input type="text" id="telephone" name="telephone"
                                    value="{{ old('telephone', $user->no_wa) }}" placeholder=" " required>
                                <label for="telephone" class="field__hint">
                                    <ion-icon name="call-outline"></ion-icon>
                                    Telephone *
                                </label>
                                @error('telephone')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="field">
                                <input type="text" id="area" name="area" value="{{ old('area', $user->area) }}"
                                    placeholder=" " required>
                                <label for="area" class="field__hint">
                                    <ion-icon name="location-outline"></ion-icon>
                                    Area *
                                </label>
                                @error('area')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <input type="text" id="instagram" name="instagram"
                                    value="{{ old('instagram', $user->instagram) }}" placeholder=" " required>
                                <label for="instagram" class="field__hint">
                                    <ion-icon name="logo-instagram"></ion-icon>
                                    Instagram *
                                </label>
                                <div class="form-help">Username Instagram tanpa @</div>
                                @error('instagram')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="field">
                                <select id="layanan_id" name="layanan_id" required>
                                    <option value="">Pilih Layanan</option>
                                    @foreach ($layanans as $layanan)
                                        <option value="{{ $layanan->id }}"
                                            {{ old('layanan_id') == $layanan->id ? 'selected' : '' }}>
                                            {{ $layanan->judul }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="layanan_id" class="field__hint">
                                    <ion-icon name="briefcase-outline"></ion-icon>
                                    Layanan *
                                </label>
                                @error('layanan_id')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                                <div id="price-list-container" class="form-help" style="margin-top:8px;"></div>
                            </div>

                            <div class="field">
                                <select id="sub_layanan_id" name="sub_layanan_id" required>
                                    <option value="">Pilih Sub Layanan</option>
                                </select>
                                <label for="sub_layanan_id" class="field__hint">
                                    <ion-icon name="grid-outline"></ion-icon>
                                    Sub Layanan *
                                </label>
                                @error('sub_layanan_id')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="field">
                                <input type="date" id="booking_date" name="booking_date"
                                    value="{{ old('booking_date') }}" min="{{ date('Y-m-d') }}" required>
                                <label for="booking_date" class="field__hint">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                    Tanggal Booking *
                                </label>
                                @error('booking_date')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="field">
                                <input type="time" id="booking_time" name="booking_time"
                                    value="{{ old('booking_time') }}" required>
                                <label for="booking_time" class="field__hint">
                                    <ion-icon name="time-outline"></ion-icon>
                                    Waktu Mulai *
                                </label>
                                @error('booking_time')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="field">
                                <input type="text" id="lokasi_photo" name="lokasi_photo"
                                    value="{{ old('lokasi_photo') }}" placeholder=" " required>
                                <label for="lokasi_photo" class="field__hint">
                                    <ion-icon name="camera-outline"></ion-icon>
                                    Lokasi Photo *
                                </label>
                                @error('lokasi_photo')
                                    <div class="field__error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="field">
                            <textarea id="catatan" name="catatan" rows="3" placeholder=" " required>{{ old('catatan') }}</textarea>
                            <label for="catatan" class="field__hint">
                                <ion-icon name="document-text-outline"></ion-icon>
                                Catatan Tambahan *
                            </label>
                            <div class="form-help">Masukkan catatan tambahan</div>
                            @error('catatan')
                                <div class="field__error">{{ $message }}</div>
                            @enderror
                        </div>

                            <div class="form-actions" style="margin-top: 40px;">
                                <button type="submit" class="submit-booking-btn btn btn-primary" style="background-color: var(--apple-accent) !important; color: white !important; border-radius: 30px !important;">
                                    <ion-icon name="checkmark-circle-outline" style="font-size: 20px; color: white !important;"></ion-icon>
                                    <span class="btn__text" style="color: white !important;">Submit Booking</span>
                                </button>
                                <a href="{{ route('booking.index') }}" class="back-booking-btn btn btn-outline-secondary" style="border-radius: 30px !important;">
                                    <ion-icon name="arrow-back-outline" style="font-size: 20px;"></ion-icon>
                                    <span>Back</span>
                                </a>
                            </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const layananData = @json($layanans);
            const fields = document.querySelectorAll('.field input, .field textarea, .field select');

            fields.forEach(function(field) {
                if (field.tagName === 'SELECT' || field.type === 'date' || field.type === 'time') {
                    field.closest('.field').classList.add('field--filled');

                    field.addEventListener('change', function() {
                        if (this.value !== '' && this.value !== null) {
                            this.closest('.field').classList.add('field--filled');
                        } else {
                            this.closest('.field').classList.remove('field--filled');
                        }
                    });

                    return;
                }

                if (field.value && field.value.trim() !== '') {
                    field.closest('.field').classList.add('field--filled');
                }

                field.addEventListener('focus', function() {
                    this.closest('.field').classList.add('field--filled');
                });

                field.addEventListener('blur', function() {
                    if (!this.value || this.value.trim() === '') {
                        this.closest('.field').classList.remove('field--filled');
                    }
                });

                field.addEventListener('input', function() {
                    if (this.value && this.value.trim() !== '') {
                        this.closest('.field').classList.add('field--filled');
                    } else {
                        this.closest('.field').classList.remove('field--filled');
                    }
                });

                field.addEventListener('change', function() {
                    if (this.value && this.value !== '') {
                        this.closest('.field').classList.add('field--filled');
                    } else {
                        this.closest('.field').classList.remove('field--filled');
                    }
                });
            });

            const layananSelect = document.getElementById('layanan_id');
            const priceListContainer = document.getElementById('price-list-container');
            if (layananSelect) {
                layananSelect.addEventListener('change', function() {
                    const layananId = this.value;
                    const subLayananSelect = document.getElementById('sub_layanan_id');

                    subLayananSelect.innerHTML = '<option value="">Pilih Sub Layanan</option>';

                    if (layananId) {
                        fetch(`/api/sub-layanan/${layananId}`)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                data.forEach(subLayanan => {
                                    const option = document.createElement('option');
                                    option.value = subLayanan.id;
                                    option.textContent = subLayanan.judul;
                                    subLayananSelect.appendChild(option);
                                });
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                subLayananSelect.innerHTML =
                                    '<option value="">Error loading sub layanan</option>';
                            });

                        if (priceListContainer) {
                            const layanan = Array.isArray(layananData) ? layananData.find(l => String(l
                                .id) === String(layananId)) : null;
                            if (layanan && layanan.price_list_pdf) {
                                const pdfUrl = '{{ asset('upload/layanan/pdf') }}/' + layanan
                                    .price_list_pdf;
                                priceListContainer.innerHTML =
                                    `<a href="${pdfUrl}" target="_blank" class="pdf-link"><i class=\"fas fa-file-pdf\"></i> Download Pricelist</a>`;
                            } else {
                                priceListContainer.innerHTML =
                                    '<span class="no-pdf-message"><i class="fas fa-info-circle"></i> Pricelist belum diupload</span>';
                            }
                        }
                    } else if (priceListContainer) {
                        priceListContainer.innerHTML = '';
                    }
                });

                const initialId = layananSelect.value;
                if (initialId && priceListContainer) {
                    const layanan = Array.isArray(layananData) ? layananData.find(l => String(l.id) === String(
                        initialId)) : null;
                    if (layanan && layanan.price_list_pdf) {
                        const pdfUrl = '{{ asset('upload/layanan/pdf') }}/' + layanan.price_list_pdf;
                        priceListContainer.innerHTML =
                            `<a href="${pdfUrl}" target="_blank" class="pdf-link"><i class=\"fas fa-file-pdf\"></i> Download Pricelist</a>`;
                    }
                }
            }

            setTimeout(function() {
                if (window.bootstrap) {
                    const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                    tooltipElements.forEach(function(el) {
                        if (!bootstrap.Tooltip.getInstance(el)) {
                            var tooltip = new bootstrap.Tooltip(el, {
                                container: 'body',
                                boundary: 'viewport'
                            });
                            el.addEventListener('shown.bs.tooltip', function() {
                                var tooltipInner = document.querySelector('.tooltip-inner');
                                if (tooltipInner) {
                                    tooltipInner.style.fontSize = '18px';
                                    tooltipInner.style.padding = '14px 20px';
                                    tooltipInner.style.minWidth = '200px';
                                    tooltipInner.style.maxWidth = '400px';
                                }
                            });
                        }
                    });
                }
            }, 100);
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
@endsection
