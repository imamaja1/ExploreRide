<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name' => 'Ayu Maharani', 'rating' => 5, 'message' => 'Pelayanan sangat memuaskan! Mobil bersih dan sopir profesional. Pasti akan pakai lagi untuk liburan berikutnya.', 'is_active' => true],
            ['name' => 'Bambang Susilo', 'rating' => 4, 'message' => 'Paket wisata ke Gunung Bromo sangat terorganisir. Harga terjangkau dengan fasilitas lengkap.', 'is_active' => true],
            ['name' => 'Cindy Permata', 'rating' => 5, 'message' => 'Rental mobilnya cepat dan mudah. Proses booking online sangat praktis, tinggal ambil mobil di lokasi.', 'is_active' => true],
            ['name' => 'Dimas Ardiansyah', 'rating' => 4, 'message' => 'Sopirnya ramah dan hafal rute wisata. Recommended banget buat yang mau liburan ke Bali.', 'is_active' => true],
            ['name' => 'Elisa Nurhayati', 'rating' => 5, 'message' => 'Pengalaman pertama sewa mobil lepas kunci, ternyata gampang banget. Mobil baru dan terawat.', 'is_active' => true],
            ['name' => 'Fajar Ramadhan', 'rating' => 3, 'message' => 'Cukup bagus, tapi sayang booking terakhir saya ada delay konfirmasi. Semoga kedepannya lebih cepat.', 'is_active' => false],
        ];

        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }
    }
}
