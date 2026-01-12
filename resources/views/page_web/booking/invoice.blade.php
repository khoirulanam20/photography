<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Booking #{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
        }

        .invoice-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            padding: 15px 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .logo-section {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo {
            width: 120px;
            height: 120px;
            background: #f0f0f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 64px;
            font-weight: bold;
            color: #999;
            flex-shrink: 0;
        }

        .logo img {
            filter: invert(1);
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-text h1 {
            font-size: 32px;
            font-weight: 300;
            margin: 0;
            color: #999;
            letter-spacing: 2px;
            line-height: 1.2;
        }

        .logo-text .subtitle {
            font-size: 12px;
            color: #999;
            margin-top: -4px;
            letter-spacing: 1px;
        }

        .company-info {
            text-align: right;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
        }

        .company-info p {
            font-size: 13px;
            color: #333;
            margin: 4px 0;
            line-height: 1.5;
        }

        .invoice-title {
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            margin: 12px 0;
            letter-spacing: 2px;
        }

        .client-info {
            margin-bottom: 15px;
        }

        .client-info h3 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .client-info p {
            font-size: 12px;
            margin: 3px 0;
        }

        .client-info p strong {
            font-weight: 600;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .invoice-table thead {
            background-color: #333;
            color: white;
        }

        .invoice-table th {
            padding: 8px 6px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            border: 1px solid #333;
        }

        .invoice-table td {
            padding: 6px 6px;
            border: 1px solid #ddd;
            font-size: 11px;
        }

        .invoice-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary-table {
            width: 100%;
            max-width: 300px;
            margin-left: auto;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 6px 10px;
            border: 1px solid #ddd;
            font-size: 11px;
        }

        .summary-table td:first-child {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 60%;
        }

        .summary-table td:last-child {
            text-align: right;
            font-weight: bold;
        }

        .summary-table .payment-row td {
            font-weight: normal;
        }

        .summary-table .divider-row td {
            border-top: 2px solid #333;
        }

        .booking-details {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .booking-details h3 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .booking-details p {
            font-size: 12px;
            margin: 3px 0;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }

        .signature-box {
            width: 45%;
            text-align: center;
        }

        .signature-box h4 {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .signature-logo-wrapper {
            margin: 10px 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .signature-logo {
            width: 100px;
            height: 100px;
            background: #f0f0f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 56px;
            font-weight: bold;
            color: #4a90e2;
            margin-bottom: 10px;
        }

        .signature-logo-text {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .signature-logo-text h2 {
            font-size: 20px;
            font-weight: 600;
            color: #4a90e2;
            margin: 0;
            letter-spacing: 1px;
        }

        .signature-logo-text .subtitle {
            font-size: 10px;
            color: #4a90e2;
            margin-top: -3px;
            letter-spacing: 0.5px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin: 20px auto 8px;
            width: 200px;
        }

        .signature-name {
            font-size: 11px;
            margin-top: 3px;
            color: #333;
        }

        .signature-empty-box {
            border: 1px solid #ddd;
            height: 60px;
            margin: 10px auto;
            width: 200px;
            background: #fafafa;
        }

        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }

        .print-button button {
            background-color: #333;
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }

        .print-button button:hover {
            background-color: #555;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .invoice-container {
                box-shadow: none;
                padding: 10px 15px;
            }

            .print-button {
                display: none;
            }

            @page {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="print-button">
        <button onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Invoice
        </button>
    </div>

    <div class="invoice-container">
        <div class="invoice-header">
            <div class="logo-section">
                <div class="logo-wrapper">
                    @if ($profil && $profil->logo_perusahaan)
                        <div class="logo">
                            <img src="{{ asset('upload/profil/' . $profil->logo_perusahaan) }}" alt="Logo">
                        </div>
                    @else
                        <div class="logo">W</div>
                    @endif
                    <div class="logo-text">
                        <h1>WISESA</h1>
                        <span class="subtitle">PHOTOGRAPHY</span>
                    </div>
                </div>
            </div>
            <div class="company-info">
                @if ($profil)
                    <p>{{ $profil->alamat_perusahaan ?? '' }}</p>
                    @php
                        $instagramAccounts = collect($profil->instagram_perusahaan ?? [])->filter();
                        $firstInstagram = $instagramAccounts->first();
                        if ($firstInstagram) {
                            $normalizedInstagram = ltrim($firstInstagram, '@');
                            $instagramDisplay = '@' . $normalizedInstagram;
                        } else {
                            $instagramDisplay = '';
                        }
                    @endphp
                    @if ($instagramDisplay)
                        <p>IG : {{ $instagramDisplay }}</p>
                    @endif
                    @if ($profil->whatsapp_perusahaan)
                        <p>WA : {{ $profil->whatsapp_perusahaan }}</p>
                    @endif
                @endif
            </div>
        </div>

        <div class="invoice-title">INVOICE</div>

        <div class="client-info">
            <p><strong>Kepada</strong> : {{ $booking->nama }}</p>
            <p><strong>Phone</strong> : {{ $booking->telephone }}</p>
            @if ($booking->user && $booking->user->email)
                <p><strong>Email</strong> : {{ $booking->user->email }}</p>
            @endif
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 30%;">DESKRIPSI</th>
                    <th style="width: 45%;">OUTPUT</th>
                    <th style="width: 20%;" class="text-right">HARGA</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                    $confirmedPayments = [];
                    $paymentHistory = [];

                    if ($booking->payments && is_array($booking->payments)) {
                        foreach ($booking->payments as $payment) {
                            if (isset($payment['status']) && $payment['status'] === 'Terkonfirmasi') {
                                $confirmedPayments[] = $payment;
                            }
                        }
                    }

                    $layananPrice = 0;
                    $biayaRaw = is_string($booking->biaya)
                        ? preg_replace('/[^0-9]/', '', $booking->biaya)
                        : $booking->biaya;
                    $layananPrice = $biayaRaw ? (float) $biayaRaw : 0;

                    foreach ($confirmedPayments as $payment) {
                        $jenisPayment = strtolower($payment['jenis_payment'] ?? '');
                        $isDiscount =
                            strpos($jenisPayment, 'disc') !== false ||
                            strpos($jenisPayment, 'diskon') !== false ||
                            strpos($jenisPayment, 'discount') !== false;
                        $isExtend = strpos($jenisPayment, 'extend') !== false;
                        $isLayanan =
                            strpos($jenisPayment, 'paket') !== false || strpos($jenisPayment, 'layanan') !== false;
                        $isDP = strpos($jenisPayment, 'dp') !== false;
                        $isFullPayment =
                            strpos($jenisPayment, 'fullpayment') !== false ||
                            strpos($jenisPayment, 'full payment') !== false;

                        if (($isDP || $isFullPayment) && !$isDiscount && !$isExtend && !$isLayanan) {
                            $paymentHistory[] = $payment;
                        }
                    }
                @endphp

                @if ($booking->layanan)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>
                            <strong>{{ $booking->layanan->judul }}</strong>
                            @if ($booking->subLayanan)
                                <br><span style="font-size: 10px;">{{ $booking->subLayanan->judul }}</span>
                            @endif
                            @if ($booking->layanan->deskripsi)
                                <br><span
                                    style="font-size: 10px; color: #666;">{{ strip_tags($booking->layanan->deskripsi) }}</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $outputDetails = [];
                                $outputDetails[] = 'Lokasi: ' . $booking->lokasi_photo;
                                $outputDetails[] = 'Tanggal: ' . $booking->booking_date->format('d F Y');
                                $startTime = date('H.i', strtotime($booking->booking_time));
                                $endTime =
                                    isset($booking->booking_end_time) && $booking->booking_end_time
                                        ? date('H.i', strtotime($booking->booking_end_time))
                                        : date('H.i', strtotime($booking->booking_time) + 3600);
                                $outputDetails[] = 'Waktu: ' . $startTime . '-' . $endTime . ' WIB';
                                if ($booking->fotografer) {
                                    $outputDetails[] = 'Fotografer: ' . $booking->fotografer;
                                }
                                if ($booking->area) {
                                    $outputDetails[] = 'Area: ' . $booking->area;
                                }
                                echo implode('<br>', $outputDetails);
                            @endphp
                        </td>
                        <td class="text-right">Rp {{ number_format($layananPrice, 0, ',', '.') }},00</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <table class="summary-table">
            @php
                $downPayment = $booking->total_paid ?? 0;
                $remaining = max(0, $layananPrice - $downPayment);
            @endphp
            <tr>
                <td>Total</td>
                <td>Rp {{ number_format($layananPrice, 0, ',', '.') }},00</td>
            </tr>
            @if (count($paymentHistory) > 0)
                @foreach ($paymentHistory as $payment)
                    @php
                        $nominal = isset($payment['nominal'])
                            ? (float) preg_replace('/[^0-9]/', '', (string) $payment['nominal'])
                            : 0;
                        $jenisPaymentRaw = $payment['jenis_payment'] ?? '';
                        $jenisPayment = '';
                        if (stripos($jenisPaymentRaw, 'dp') !== false) {
                            $jenisPayment = 'DP';
                        } elseif (
                            stripos($jenisPaymentRaw, 'fullpayment') !== false ||
                            stripos($jenisPaymentRaw, 'full payment') !== false
                        ) {
                            $jenisPayment = 'Full Payment';
                        } else {
                            $jenisPayment = ucfirst($jenisPaymentRaw);
                        }
                    @endphp
                    <tr class="payment-row">
                        <td>{{ $jenisPayment }}</td>
                        <td>Rp {{ number_format($nominal, 0, ',', '.') }},00</td>
                    </tr>
                @endforeach
            @endif
            <tr class="divider-row">
                <td>Uang Muka</td>
                <td>Rp {{ number_format($downPayment, 0, ',', '.') }},00</td>
            </tr>
            <tr>
                <td>Sisa Pelunasan</td>
                <td>Rp {{ number_format($remaining, 0, ',', '.') }},00</td>
            </tr>
        </table>

        <div class="booking-details">
            <h3>Detail Booking</h3>
            <p><strong>Lokasi:</strong> {{ $booking->lokasi_photo }}</p>
            <p><strong>Tanggal:</strong> {{ $booking->booking_date->format('d F Y') }}</p>
            @php
                $startTime = date('H.i', strtotime($booking->booking_time));
                $endTime = $booking->booking_end_time
                    ? date('H.i', strtotime($booking->booking_end_time))
                    : date('H.i', strtotime($booking->booking_time) + 3600);
            @endphp
            <p><strong>Waktu:</strong> {{ $startTime }}-{{ $endTime }} WIB</p>
        </div>

        <div class="signature-section">
            <div class="signature-box">
                <h4>Penerima Pesanan</h4>
                <div class="signature-logo-wrapper"> <br><br><br>
                </div>
                <div class="signature-line"></div>
                <div class="signature-name">({{ $profil->nama_perusahaan ?? 'WISESA PHOTOGRAPHY' }})</div>
            </div>
            <div class="signature-box">
                <h4>Pemesan<br><br><br><br><br> </h4>
                <div class="signature-line"></div>
                <div class="signature-name">({{ substr($booking->nama, 0, 10) }})</div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            if (window.location.search.includes('print=true')) {
                window.print();
            }
        }
    </script>
</body>

</html>
