<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Models\Setting;
use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingCancelled extends Notification
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
        $customerName = $this->booking->customer?->name ?? '-';
        $carInfo = $this->booking->car
            ? $this->booking->car->brand.' '.$this->booking->car->name
            : '-';

        return "*ExploreRide - Pesanan Dibatalkan*\n\n"
            ."Halo {$notifiable->name}!\n\n"
            ."Pesanan berikut telah dibatalkan:\n"
            ."Kode Booking: {$this->booking->booking_code}\n"
            ."Pelanggan: {$customerName}\n"
            ."Mobil: {$carInfo}\n"
            ."Tanggal: {$this->booking->start_date} - {$this->booking->end_date}\n"
            .'Total: Rp '.number_format($this->booking->total_price, 0, ',', '.')."\n\n"
            .'Hubungi admin untuk informasi lebih lanjut.';
    }

    public function toMail(object $notifiable): MailMessage
    {
        $customerName = $this->booking->customer?->name ?? '-';
        $carInfo = $this->booking->car
            ? $this->booking->car->brand.' '.$this->booking->car->name
            : '-';

        return (new MailMessage)
            ->subject('ExploreRide - Pesanan Dibatalkan')
            ->view('emails.booking-cancelled', [
                'recipientName' => $notifiable->name,
                'customerName' => $customerName,
                'carInfo' => $carInfo,
                'booking' => $this->booking,
            ]);
    }
}
