<?php

namespace Database\Seeders;

use App\Models\Discussion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Discussion::create([
            'sender_users_id' => 3,
            'category_discussion_categories_id' => 6,
            'title' => 'Form Di Laravel',
            'slug' => 'form-di-laravel',
            'description' => '<p style="text-align:justify;">Apakah di laravel 8 untuk put dan patch di route pada halaman html gak menggunakan method put / patch?, soalnya di codingan saya make method malah error, kalo gak make mau di update</p><p style="text-align:justify;">Untuk htmlnya pada form gak make method patch bisa update,kalo make error</p>',
        ]);
    }
}
