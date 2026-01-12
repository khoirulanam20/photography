<!-- Payment Modal -->
<div id="paymentModal" class="modal-overlay" style="display: none;">
    <div class="modal-container" style="max-height: 90vh; display: flex; flex-direction: column;">
        <div class="modal-content" style="display: flex; flex-direction: column; height: 100%; max-height: 90vh;">
            <!-- Modal Header -->
            <div class="modal-header" style="flex-shrink: 0;">
                <h3 class="modal-title">Payment</h3>
                <button type="button" class="modal-close" onclick="closePaymentModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="flex: 1; overflow-y: auto; min-height: 0; padding: 24px;">
                <!-- Payment Information -->
                <div id="payment-info"
                    style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="font-weight: 600; color: #333;">Total Biaya:</span>
                        <span id="total-biaya" style="font-weight: 700; color: #333; font-size: 18px;">Rp 0</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span style="font-weight: 600; color: #28a745;">Total Dibayar:</span>
                        <span id="total-dibayar" style="font-weight: 700; color: #28a745; font-size: 18px;">Rp 0</span>
                    </div>
                    <div
                        style="display: flex; justify-content: space-between; padding-top: 10px; border-top: 2px solid #dee2e6;">
                        <span style="font-weight: 600; color: #dc3545;">Sisa Bayar:</span>
                        <span id="sisa-bayar" style="font-weight: 700; color: #dc3545; font-size: 18px;">Rp 0</span>
                    </div>
                </div>

                <!-- Payment History -->
                <div id="payment-history" style="margin-bottom: 20px;">
                    <h4 style="margin-bottom: 15px; font-size: 16px; font-weight: 600; color: #333;">Riwayat Pembayaran
                    </h4>
                    <div id="payment-history-list" style="max-height: 250px; overflow-y: auto; padding-right: 5px;">
                        <p style="text-align: center; color: #6c757d; padding: 20px;">Belum ada riwayat pembayaran</p>
                    </div>
                </div>

                <!-- Form Content -->
                <div id="form-content">
                    <h4 style="margin-bottom: 15px; font-size: 16px; font-weight: 600; color: #333;">Tambah Pembayaran
                        Baru</h4>
                    <form id="paymentForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Payment Type Field -->
                        <div class="form-field">
                            <label for="jenis_payment" class="form-label">Jenis Payment</label>
                            <select name="jenis_payment" id="jenis_payment" class="form-input" required>
                                <option value="">Pilih Jenis Payment</option>
                                <option value="DP">DP (Down Payment)</option>
                                <option value="Fullpayment">Full Payment</option>
                            </select>
                        </div>

                        <!-- Amount Field -->
                        <div class="form-field">
                            <label for="nominal" class="form-label">Nominal</label>
                            <input type="number" name="nominal" id="nominal" class="form-input"
                                placeholder="Masukkan nominal pembayaran" required>
                        </div>

                        <!-- File Upload Field -->
                        <div class="form-field">
                            <label for="bukti_transfer" class="form-label">Unggah Bukti Transfer</label>
                            <div class="file-upload-area" onclick="document.getElementById('bukti_transfer').click()">
                                <input type="file" name="bukti_transfer" id="bukti_transfer" class="file-input"
                                    accept="image/*" required>
                                <div class="file-upload-content">
                                    <div class="file-upload-icon">
                                        <i class="fas fa-mountain-sun"></i>
                                    </div>
                                    <div class="file-upload-text">Unggah Bukti Transfer</div>
                                    <div class="file-upload-hint">Klik untuk memilih file atau drag & drop</div>
                                </div>
                            </div>
                            <div id="file-preview" class="file-preview" style="display: none;">
                                <img id="preview-image" src="" alt="Preview" class="preview-image">
                                <div class="file-info">
                                    <div class="file-name"></div>
                                    <button type="button" class="remove-file" onclick="removeFile()">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer" style="flex-shrink: 0;">
                <button type="button" class="btn-cancel" onclick="closePaymentModal()">Batal</button>
                <button type="button" class="btn-save" onclick="submitPaymentForm()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Payment Modal Functions
    let currentBookingId = null;

    function openPaymentModal(bookingId) {
        currentBookingId = bookingId;

        const form = document.getElementById('paymentForm');
        if (bookingId) {
            form.action = `/booking/${bookingId}/payment`;
        }

        loadPaymentData(bookingId);

        document.getElementById('paymentModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function loadPaymentData(bookingId) {
        fetch(`/booking/${bookingId}/payment-data`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('total-biaya').textContent = formatCurrency(data.biaya);
                    document.getElementById('total-dibayar').textContent = formatCurrency(data.total_dibayar);
                    document.getElementById('sisa-bayar').textContent = formatCurrency(data.sisa_bayar);

                    updatePaymentHistory(data.payments);

                    const formContent = document.getElementById('form-content');
                    const modalFooter = document.querySelector('.modal-footer');
                    const saveBtn = document.querySelector('.btn-save');
                    if (Number(data.sisa_bayar) <= 0) {
                        if (formContent) formContent.style.display = 'none';
                        if (saveBtn) saveBtn.style.display = 'none';
                    } else {
                        if (formContent) formContent.style.display = 'block';
                        if (saveBtn) saveBtn.style.display = 'inline-block';
                    }
                }
            })
            .catch(error => {
                console.error('Error loading payment data:', error);
            });
    }

    function formatCurrency(amount) {
        return 'Rp ' + parseFloat(amount).toLocaleString('id-ID');
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function getStatusBadge(status) {
        const badges = {
            'Pending': '<span style="padding: 4px 8px; background: #ffc107; color: #000; border-radius: 4px; font-size: 12px; font-weight: 600;">Pending</span>',
            'Terkonfirmasi': '<span style="padding: 4px 8px; background: #28a745; color: #fff; border-radius: 4px; font-size: 12px; font-weight: 600;">Terkonfirmasi</span>',
            'Ditolak': '<span style="padding: 4px 8px; background: #dc3545; color: #fff; border-radius: 4px; font-size: 12px; font-weight: 600;">Ditolak</span>'
        };
        return badges[status] || badges['Pending'];
    }

    function updatePaymentHistory(payments) {
        const historyList = document.getElementById('payment-history-list');

        if (!payments || payments.length === 0) {
            historyList.innerHTML =
                '<p style="text-align: center; color: #6c757d; padding: 20px;">Belum ada riwayat pembayaran</p>';
            return;
        }

        let html = '<div style="display: flex; flex-direction: column; gap: 10px;">';

        payments.forEach((payment, index) => {
            const imageUrl = `/booking/payment-image/${payment.bukti_transfer}`;
            html += `
                <div style="padding: 12px; border: 1px solid #dee2e6; border-radius: 8px; background: #fff;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                        <div>
                            <div style="font-weight: 600; color: #333; margin-bottom: 4px;">${payment.jenis_payment}</div>
                            <div style="font-size: 14px; color: #6c757d;">${formatDate(payment.created_at)}</div>
                            ${payment.catatan_admin ? `<div style="font-size: 13px; color: #6c757d; margin-top: 6px;">Catatan: ${payment.catatan_admin}</div>` : ''}
                        </div>
                        ${getStatusBadge(payment.status)}
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                        <span style="font-weight: 600; color: #333; font-size: 16px;">${formatCurrency(payment.nominal)}</span>
                        <a href="${imageUrl}" target="_blank" style="color: #007bff; text-decoration: none; font-size: 14px;">
                            <i class="fas fa-eye"></i> Lihat Bukti
                        </a>
                    </div>
                </div>
            `;
        });

        html += '</div>';
        historyList.innerHTML = html;
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        resetPaymentForm();
    }

    function resetPaymentForm() {
        document.getElementById('paymentForm').reset();
        document.getElementById('file-preview').style.display = 'none';
        document.getElementById('bukti_transfer').value = '';
        document.querySelector('.file-upload-area').style.display = 'block';
        document.getElementById('form-content').style.display = 'block';
        document.querySelector('.modal-footer').style.display = 'flex';
    }

    function submitPaymentForm() {
        const form = document.getElementById('paymentForm');
        const formData = new FormData(form);

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const saveBtn = document.querySelector('.btn-save');
        const originalText = saveBtn.textContent;
        saveBtn.textContent = 'Menyimpan...';
        saveBtn.disabled = true;

        fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const contentType = response.headers.get('content-type') || '';
                if (contentType.includes('application/json')) {
                    return response.json();
                }
                const text = await response.text();
                throw new Error(text || 'Unexpected non-JSON response');
            })
            .then(data => {
                if (data.success) {
                    if (currentBookingId) {
                        loadPaymentData(currentBookingId);
                    }

                    resetPaymentForm();
                    closePaymentModal();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Payment berhasil disimpan! Terima kasih! Payment Anda sedang diproses oleh admin.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    saveBtn.textContent = originalText;
                    saveBtn.disabled = false;

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Terjadi kesalahan saat menyimpan payment',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);

                saveBtn.textContent = originalText;
                saveBtn.disabled = false;

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat menyimpan payment',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
            });
    }

    // File upload handling
    document.getElementById('bukti_transfer').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.querySelector('.file-name').textContent = file.name;
                document.getElementById('file-preview').style.display = 'block';
                document.querySelector('.file-upload-area').style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    function removeFile() {
        document.getElementById('bukti_transfer').value = '';
        document.getElementById('file-preview').style.display = 'none';
        document.querySelector('.file-upload-area').style.display = 'block';
    }


    document.getElementById('paymentModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePaymentModal();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePaymentModal();
        }
    });
</script>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Custom Scrollbar untuk Modal Body */
    .modal-body::-webkit-scrollbar {
        width: 8px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Firefox */
    .modal-body {
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }

    /* Custom Scrollbar untuk Payment History */
    #payment-history-list::-webkit-scrollbar {
        width: 6px;
    }

    #payment-history-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #payment-history-list::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    #payment-history-list::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    #payment-history-list {
        scrollbar-width: thin;
        scrollbar-color: #ccc #f1f1f1;
    }
</style>
