<?php

namespace App\Notifications;

use App\Models\Booking;
use App\Models\Setting;
use App\Notifications\Channels\WhatsAppChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TripStarted extends Notification
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
        $driverName = $this->booking->driver?->name ?? '-';
        $carInfo = $this->booking->car
            ? $this->booking->car->brand.' '.$this->booking->car->name
            : '-';
        $customerName = $this->booking->customer?->name ?? '-';

        return "*ExploreRide - Perjalanan Dimulai*\n\n"
            ."Halo {$notifiable->name}!\n\n"
            ."Perjalanan telah dimulai.\n"
            ."Kode Booking: {$this->booking->booking_code}\n"
            ."Pelanggan: {$customerName}\n"
            ."Driver: {$driverName}\n"
            ."Mobil: {$carInfo}\n"
            ."Tanggal: {$this->booking->start_date} - {$this->booking->end_date}";
    }

    public function toMail(object $notifiable): MailMessage
    {
        $driverName = $this->booking->driver?->name ?? '-';
        $carInfo = $this->booking->car
            ? $this->booking->car->brand.' '.$this->booking->car->name
            : '-';
        $customerName = $this->booking->customer?->name ?? '-';

        return (new MailMessage)
            ->subject('ExploreRide - Perjalanan Dimulai')
            ->view('emails.trip-started', [
                'recipientName' => $notifiable->name,
                'customerName' => $customerName,
                'driverName' => $driverName,
                'carInfo' => $carInfo,
                'booking' => $this->booking,
            ]);
    }
}
