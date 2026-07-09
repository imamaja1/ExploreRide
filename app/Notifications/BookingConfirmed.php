<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $carInfo = $this->booking->car
            ? $this->booking->car->brand . ' ' . $this->booking->car->name
            : '-';

        return (new MailMessage)
            ->subject(__('Pesanan Dikonfirmasi') . ' - ExploreRide')
            ->greeting(__('Halo') . ' ' . $notifiable->name . '!')
            ->line(__('Pesanan Anda dengan kode') . ' **' . $this->booking->booking_code . '** ' . __('telah dikonfirmasi.'))
            ->line(__('Mobil') . ': ' . $carInfo)
            ->line(__('Tanggal') . ': ' . $this->booking->start_date . ' - ' . $this->booking->end_date)
            ->line(__('Total') . ': ' . __('Rp') . ' ' . number_format($this->booking->total_price, 0, ',', '.'))
            ->action(__('Lihat Pesanan'), url('/booking/' . $this->booking->id))
            ->line(__('Terima kasih telah menggunakan ExploreRide!'));
    }

    public function toWhatsApp(object $notifiable): string
    {
        $carInfo = $this->booking->car
            ? $this->booking->car->brand . ' ' . $this->booking->car->name
            : '-';

        return "*ExploreRide - " . __('Pesanan Dikonfirmasi') . "*\n\n"
            . __('Halo') . " {$notifiable->name}!\n\n"
            . __('Pesanan Anda telah dikonfirmasi.') . "\n"
            . __('Kode Booking') . ": {$this->booking->booking_code}\n"
            . __('Mobil') . ": {$carInfo}\n"
            . __('Tanggal') . ": {$this->booking->start_date} - {$this->booking->end_date}\n"
            . __('Total') . ": " . __('Rp') . " " . number_format($this->booking->total_price, 0, ',', '.') . "\n\n"
            . __('Terima kasih telah menggunakan ExploreRide!');
    }
}
