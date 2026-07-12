<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Models\Setting;
use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCreated extends Notification
{
    public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        $channels = [WhatsAppChannel::class];
        if (Setting::get('email_enabled') === '1') {
            $channels[] = 'mail';
        }
        return $channels;
    }

    public function toWhatsApp(object $notifiable): string
    {
        $carInfo = $this->booking->car
            ? $this->booking->car->brand.' '.$this->booking->car->name
            : '-';

        return "*ExploreRide - Booking Baru*\n\n"
            ."Halo {$notifiable->name}!\n\n"
            ."Booking Anda telah dibuat.\n"
            ."Kode Booking: {$this->booking->booking_code}\n"
            ."Mobil: {$carInfo}\n"
            ."Tanggal: {$this->booking->start_date} - {$this->booking->end_date}\n"
            .'Total: Rp '.number_format($this->booking->total_price, 0, ',', '.')."\n\n"
            .'Silakan lakukan pembayaran untuk melanjutkan pesanan.';
    }

    public function toMail(object $notifiable): MailMessage
    {
        $carInfo = $this->booking->car
            ? $this->booking->car->brand.' '.$this->booking->car->name
            : '-';

        return (new MailMessage)
            ->subject('ExploreRide - Booking Baru')
            ->view('emails.booking-created', [
                'customerName' => $notifiable->name,
                'carInfo' => $carInfo,
                'booking' => $this->booking,
            ]);
    }
}
