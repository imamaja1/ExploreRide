<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: #198754; padding: 20px; border-radius: 8px 8px 0 0; text-align: center;">
            <h2 style="color: #fff; margin: 0;">ExploreRide - Perjalanan Selesai</h2>
        </div>
        <div style="background: #fff; padding: 20px; border: 1px solid #e5e7eb; border-radius: 0 0 8px 8px;">
            <p>Halo {{ $recipientName }}!</p>
            <p>Perjalanan telah selesai.</p>
            <table style="width: 100%; border-collapse: collapse;">
                <tr><td style="padding: 8px 0; color: #666;">Kode Booking</td><td style="font-weight: bold;">{{ $booking->booking_code }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Pelanggan</td><td>{{ $customerName }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Driver</td><td>{{ $driverName }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Mobil</td><td>{{ $carInfo }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Tanggal</td><td>{{ $booking->start_date }} - {{ $booking->end_date }}</td></tr>
            </table>
            <p style="margin-top: 20px;">Terima kasih telah menggunakan ExploreRide!</p>
        </div>
    </div>
</body>
</html>
