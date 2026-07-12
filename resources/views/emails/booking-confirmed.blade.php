<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: #198754; padding: 20px; border-radius: 8px 8px 0 0; text-align: center;">
            <h2 style="color: #fff; margin: 0;">ExploreRide - Pesanan Dikonfirmasi</h2>
        </div>
        <div style="background: #fff; padding: 20px; border: 1px solid #e5e7eb; border-radius: 0 0 8px 8px;">
            <p>Halo {{ $customerName }}!</p>
            <p>Pesanan Anda telah dikonfirmasi. Berikut detailnya:</p>
            <table style="width: 100%; border-collapse: collapse;">
                <tr><td style="padding: 8px 0; color: #666;">Kode Booking</td><td style="font-weight: bold;">{{ $booking->booking_code }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Mobil</td><td>{{ $carInfo }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Tanggal</td><td>{{ $booking->start_date }} - {{ $booking->end_date }}</td></tr>
                <tr><td style="padding: 8px 0; color: #666;">Total</td><td style="font-weight: bold; color: #198754;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td></tr>
            </table>
            <p style="margin-top: 20px;">Terima kasih telah menggunakan ExploreRide!</p>
            <a href="{{ url('/booking/' . $booking->id) }}" style="display: inline-block; background: #198754; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 10px;">Lihat Pesanan</a>
        </div>
    </div>
</body>
</html>
