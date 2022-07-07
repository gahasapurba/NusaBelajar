<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Announcement::create([
            'title' => 'Selamat Datang di NusaBelajar',
            'content' => '<p>Selamat Datang di Website NusaBelajar. NusaBelajar hadir sebagai platform pembelajaran online yang dapat diakses oleh setiap masyarakat Indonesia tanpa batasan ruang dan waktu demi #MencerdaskanIndonesia</p>',
        ]);
    }
}
