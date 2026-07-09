<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DriverAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $customerName = $this->booking->customer?->name ?? '-';
        $carInfo = $this->booking->car
            ? $this->booking->car->brand . ' ' . $this->booking->car->name
            : '-';
        $plateNumber = $this->booking->car?->plate_number ?? '-';

        return (new MailMessage)
            ->subject(__('Anda Ditugaskan') . ' - ExploreRide')
            ->greeting(__('Halo') . ' ' . $notifiable->name . '!')
            ->line(__('Anda ditugaskan sebagai driver untuk pesanan:'))
            ->line(__('Kode Booking') . ': **' . $this->booking->booking_code . '**')
            ->line(__('Pelanggan') . ': ' . $customerName)
            ->line(__('Mobil') . ': ' . $carInfo)
            ->line(__('Plat Nomor') . ': ' . $plateNumber)
            ->line(__('Tanggal') . ': ' . $this->booking->start_date . ' - ' . $this->booking->end_date)
            ->line(__('Lokasi Jemput') . ': ' . ($this->booking->pickup_location ?? '-'))
            ->line(__('Jam Jemput') . ': ' . ($this->booking->pickup_time ?? '-'))
            ->action(__('Lihat Detail'), url('/driver/dashboard'))
            ->line(__('Silakan hubungi pelanggan untuk koordinasi lebih lanjut.'));
    }

    public function toWhatsApp(object $notifiable): string
    {
        $customerName = $this->booking->customer?->name ?? '-';
        $carInfo = $this->booking->car
            ? $this->booking->car->brand . ' ' . $this->booking->car->name
            : '-';
        $plateNumber = $this->booking->car?->plate_number ?? '-';

        return "*ExploreRide - " . __('Penugasan Driver') . "*\n\n"
            . __('Halo') . " {$notifiable->name}!\n\n"
            . __('Anda ditugaskan untuk pesanan berikut:') . "\n"
            . __('Kode Booking') . ": {$this->booking->booking_code}\n"
            . __('Pelanggan') . ": {$customerName}\n"
            . __('Mobil') . ": {$carInfo}\n"
            . __('Plat Nomor') . ": {$plateNumber}\n"
            . __('Tanggal') . ": {$this->booking->start_date} - {$this->booking->end_date}\n"
            . __('Lokasi Jemput') . ": " . ($this->booking->pickup_location ?? '-') . "\n"
            . __('Jam Jemput') . ": " . ($this->booking->pickup_time ?? '-') . "\n\n"
            . __('Silakan hubungi pelanggan untuk koordinasi.');
    }
}
