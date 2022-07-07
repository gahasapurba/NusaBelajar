<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Discount::create([
            'name' => 'Promo Selamat Datang di NusaBelajar',
            'description' => '<p style="text-align:justify;">Terima kasih telah menjadi bagian dari NusaBelajar. Atas antusiasme anda terhadap NusaBelajar, kami dengan sengan hati memberikan penawaran kami berupa potongan harga sebesar <strong>25%</strong> untuk setiap pembelian kelas di website NusaBelajar. Terima kasih</p>',
            'code' => 'NBWELCOME',
            'percentage' => 25,
        ]);
    }
}
