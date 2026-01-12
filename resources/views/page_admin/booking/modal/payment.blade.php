<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <div>
                    <h5 class="modal-title mb-0" id="paymentModalLabel">Payment</h5>
                    <span id="payment_status_badge" class="badge mt-2" style="display: none;"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-lg-5">
                        <div class="border rounded p-3 mb-3 bg-light">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-semibold">Total Biaya</span>
                                <span id="admin_total_biaya" class="fw-bold">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-success fw-semibold">Total Dibayar</span>
                                <span id="admin_total_dibayar" class="fw-bold text-success">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between pt-2 border-top">
                                <span class="text-danger fw-semibold">Sisa Bayar</span>
                                <span id="admin_sisa_bayar" class="fw-bold text-danger">Rp 0</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bukti Transfer</label>
                            <div id="bukti_transfer_container" class="border rounded p-3 text-center bg-white"
                                style="min-height: 260px; display: flex; align-items: center; justify-content: center;">
                                <div id="bukti_transfer_placeholder">
                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                    <p class="text-muted mb-0">Bukti Transfer</p>
                                </div>
                                <img id="bukti_transfer_image" src="" alt="Bukti Transfer"
                                    class="img-fluid d-none" style="max-height: 360px;">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="mb-0">Riwayat Pembayaran</h6>
                            <span class="small text-muted" id="admin_payments_count">0 item</span>
                        </div>
                        <div id="admin_payments_list" class="list-group" style="max-height: 420px; overflow-y: auto;">
                            <div class="text-center text-muted py-4">Belum ada pembayaran</div>
                        </div>

                        <div id="admin_action_panel" class="card mt-3" style="display: none;">
                            <div class="card-body">
                                <div class="mb-2">
                                    <label for="admin_note" class="form-label">Catatan</label>
                                    <textarea id="admin_note" class="form-control" rows="2" placeholder="Tambahkan catatan untuk tindakan ini..."></textarea>
                                </div>
                                <div class="d-flex gap-2" id="admin_action_buttons">
                                    <button type="button" class="btn btn-outline-danger" id="btnTolak">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                    <button type="button" class="btn btn-success text-white" id="btnVerifikasi">
                                        <i class="fas fa-check"></i> Verifikasi
                                    </button>
                                </div>
                                <div class="text-muted" id="admin_action_hint" style="display:none;">
                                    Pembayaran ini sudah diproses.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentModal = document.getElementById('paymentModal');
        const btnVerifikasi = document.getElementById('btnVerifikasi');

        let currentBookingId = null;
        let paymentsData = [];
        let selectedPaymentIndex = null;

        paymentModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            currentBookingId = button.getAttribute('data-booking-id');

            document.getElementById('bukti_transfer_image').src = '';
            document.getElementById('bukti_transfer_placeholder').classList.remove('d-none');
            document.getElementById('bukti_transfer_image').classList.add('d-none');

            document.getElementById('payment_status_badge').style.display = 'none';

            const actionPanel = document.getElementById('admin_action_panel');
            const actionButtons = document.getElementById('admin_action_buttons');
            const actionHint = document.getElementById('admin_action_hint');
            const noteEl = document.getElementById('admin_note');
            if (actionPanel) actionPanel.style.display = 'none';
            if (actionButtons) actionButtons.style.display = 'none';
            if (actionHint) actionHint.style.display = 'none';
            if (noteEl) {
                noteEl.value = '';
                noteEl.readOnly = false;
            }

            fetch(`/super-admin/payment/${currentBookingId}/json`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        paymentsData = Array.isArray(data.payments) ? data.payments : [];

                        const totalBiaya = Number(data.biaya || 0);
                        const totalDibayar = paymentsData
                            .filter(p => (p.status || 'Pending') === 'Terkonfirmasi')
                            .reduce((sum, p) => sum + Number(p.nominal || 0), 0);
                        const sisaBayar = Math.max(0, totalBiaya - totalDibayar);
                        document.getElementById('admin_total_biaya').textContent = 'Rp ' + new Intl
                            .NumberFormat('id-ID').format(totalBiaya);
                        document.getElementById('admin_total_dibayar').textContent = 'Rp ' +
                            new Intl.NumberFormat('id-ID').format(totalDibayar);
                        document.getElementById('admin_sisa_bayar').textContent = 'Rp ' + new Intl
                            .NumberFormat('id-ID').format(sisaBayar);

                        const listEl = document.getElementById('admin_payments_list');
                        const countEl = document.getElementById('admin_payments_count');
                        countEl.textContent = `${paymentsData.length} item`;
                        if (paymentsData.length === 0) {
                            listEl.innerHTML =
                                '<div class="text-center text-muted py-4">Belum ada pembayaran</div>';
                            const panel = document.getElementById('admin_action_panel');
                            if (panel) panel.style.display = 'none';
                            return;
                        }

                        listEl.innerHTML = paymentsData.map((p, idx) => {
                            const badge = p.status === 'Terkonfirmasi' ?
                                '<span class="badge bg-success">Terkonfirmasi</span>' :
                                (p.status === 'Ditolak' ?
                                    '<span class="badge bg-danger">Ditolak</span>' :
                                    '<span class="badge bg-warning text-dark">Pending</span>'
                                );
                            return `
                                <button type="button" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-index="${idx}">
                                    <div>
                                        <div class="fw-semibold mb-1">${p.jenis_payment || '-'}</div>
                                        <div class="small text-muted">${new Date(p.created_at || Date.now()).toLocaleString('id-ID')}</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">Rp ${new Intl.NumberFormat('id-ID').format(Number(p.nominal || 0))}</div>
                                        ${badge}
                                    </div>
                                </button>
                            `;
                        }).join('');

                        const defaultIndex = paymentsData.findIndex(p => (p.status || 'Pending') ===
                            'Pending');
                        setSelectedPayment(defaultIndex >= 0 ? defaultIndex : (paymentsData.length -
                            1));

                        listEl.querySelectorAll('[data-index]').forEach(btn => {
                            btn.addEventListener('click', () => {
                                const idx = Number(btn.getAttribute('data-index'));
                                setSelectedPayment(idx);
                            });
                        });

                        const placeholder = document.getElementById('bukti_transfer_placeholder');
                        const image = document.getElementById('bukti_transfer_image');
                        updateStatusAndPreview();
                    } else {
                        const modal = bootstrap.Modal.getInstance(paymentModal);
                        modal.hide();

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Gagal memuat data pembayaran',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const modal = bootstrap.Modal.getInstance(paymentModal);
                    modal.hide();

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memuat data pembayaran',
                        confirmButtonText: 'OK'
                    });
                });
        });

        function setSelectedPayment(index) {
            selectedPaymentIndex = index;
            updateStatusAndPreview();
        }

        function updateStatusAndPreview() {
            const p = (selectedPaymentIndex != null) ? paymentsData[selectedPaymentIndex] : null;
            const statusBadge = document.getElementById('payment_status_badge');
            const actionPanel = document.getElementById('admin_action_panel');
            const actionButtons = document.getElementById('admin_action_buttons');
            const actionHint = document.getElementById('admin_action_hint');
            const noteEl = document.getElementById('admin_note');
            const placeholder = document.getElementById('bukti_transfer_placeholder');
            const image = document.getElementById('bukti_transfer_image');

            if (!p) {
                statusBadge.style.display = 'none';
                if (actionPanel) actionPanel.style.display = 'none';
                placeholder.classList.remove('d-none');
                image.classList.add('d-none');
                image.src = '';
                return;
            }

            if (p.status === 'Terkonfirmasi') {
                statusBadge.textContent = 'Terkonfirmasi';
                statusBadge.className = 'badge bg-success mt-2';
                statusBadge.style.display = 'inline-block';
            } else if (p.status === 'Pending') {
                statusBadge.textContent = 'Pending';
                statusBadge.className = 'badge bg-warning mt-2';
                statusBadge.style.display = 'inline-block';
            } else {
                statusBadge.textContent = 'Ditolak';
                statusBadge.className = 'badge bg-danger mt-2';
                statusBadge.style.display = 'inline-block';
            }

            if (actionPanel) actionPanel.style.display = 'block';
            if (noteEl) noteEl.value = p.catatan_admin || '';
            const statusStr = ((p.status || 'Pending') + '').trim();
            const isPending = statusStr.toLowerCase() === 'pending';
            const isProcessed = !isPending;
            if (noteEl) noteEl.readOnly = isProcessed;
            if (actionButtons) {
                actionButtons.style.display = isProcessed ? 'none' : 'flex';
                const vBtn = document.getElementById('btnVerifikasi');
                const tBtn = document.getElementById('btnTolak');
                if (vBtn) vBtn.style.display = isPending ? 'inline-block' : 'none';
                if (tBtn) tBtn.style.display = isPending ? 'inline-block' : 'none';
            }
            if (actionHint) actionHint.style.display = isProcessed ? 'block' : 'none';

            const imageUrl = p.bukti_transfer ? `/super-admin/payment-image/${p.bukti_transfer}` : '';
            if (imageUrl) {
                image.src = imageUrl;
                image.onerror = function() {
                    placeholder.classList.remove('d-none');
                    image.classList.add('d-none');
                };
                image.onload = function() {
                    placeholder.classList.add('d-none');
                    image.classList.remove('d-none');
                };
            } else {
                placeholder.classList.remove('d-none');
                image.classList.add('d-none');
                image.src = '';
            }
        }

        btnVerifikasi.addEventListener('click', function() {
            if (!currentBookingId) {
                return;
            }

            if (selectedPaymentIndex == null) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pilih salah satu pembayaran terlebih dahulu.'
                });
                return;
            }

            btnVerifikasi.disabled = true;
            btnVerifikasi.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                'content');

            const note = (document.getElementById('admin_note')?.value || '').trim();
            fetch(`/super-admin/payment/${currentBookingId}/verifikasi`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_index: selectedPaymentIndex,
                        catatan: note
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(paymentModal);
                        modal.hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message || 'Pembayaran berhasil diverifikasi',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        btnVerifikasi.disabled = false;
                        btnVerifikasi.innerHTML = '<i class="fas fa-check"></i> Verivikasi';

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Gagal memverifikasi pembayaran',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    btnVerifikasi.disabled = false;
                    btnVerifikasi.innerHTML = '<i class="fas fa-check"></i> Verivikasi';

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memverifikasi pembayaran',
                        confirmButtonText: 'OK'
                    });
                });
        });

        const btnTolak = document.getElementById('btnTolak');
        btnTolak.addEventListener('click', function() {
            if (!currentBookingId) return;
            if (selectedPaymentIndex == null) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: 'Pilih salah satu pembayaran terlebih dahulu.'
                });
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                'content');
            const note = (document.getElementById('admin_note')?.value || '').trim();

            btnTolak.disabled = true;
            const originalHtml = btnTolak.innerHTML;
            btnTolak.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

            fetch(`/super-admin/payment/${currentBookingId}/tolak`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_index: selectedPaymentIndex,
                        catatan: note
                    })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(paymentModal);
                        modal.hide();
                        Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message || 'Pembayaran ditolak.'
                            })
                            .then(() => window.location.reload());
                    } else {
                        btnTolak.disabled = false;
                        btnTolak.innerHTML = originalHtml;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Gagal menolak pembayaran.'
                        });
                    }
                })
                .catch(err => {
                    console.error(err);
                    btnTolak.disabled = false;
                    btnTolak.innerHTML = originalHtml;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menolak pembayaran.'
                    });
                });
        });
    });
</script>
