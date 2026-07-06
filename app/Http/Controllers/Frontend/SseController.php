<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SseController extends Controller
{
    public function stream($id)
    {
        $response = new StreamedResponse(function () use ($id) {
            $lastStatus = null;
            $lastDriverId = null;

            while (true) {
                if (connection_aborted()) {
                    break;
                }

                $booking = Booking::with('driver')->find($id);

                if (!$booking) {
                    echo "event: error\n";
                    echo "data: Booking tidak ditemukan\n\n";
                    ob_flush();
                    flush();
                    break;
                }

                $currentStatus = $booking->status;
                $currentDriverId = $booking->driver_id;

                if ($currentStatus !== $lastStatus || $currentDriverId !== $lastDriverId) {
                    $data = [
                        'status' => $booking->status,
                        'driver' => $booking->driver ? [
                            'name' => $booking->driver->name,
                            'phone' => $booking->driver->phone,
                            'plate_number' => $booking->driver->plate_number,
                        ] : null,
                    ];

                    echo "event: update\n";
                    echo "data: " . json_encode($data) . "\n\n";

                    $lastStatus = $currentStatus;
                    $lastDriverId = $currentDriverId;
                }

                ob_flush();
                flush();

                sleep(2);
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        return $response;
    }
}
