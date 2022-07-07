<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::create([
            'organizer_users_id' => 2,
            'category_event_categories_id' => 9,
            'title' => 'Indocomtech 2022',
            'slug' => 'indocomtech-2022',
            'location' => 'https://www.loket.com/event/indocomtech-2022_bb2g',
            'google_map_link' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.374034479288!2d106.8050168153516!3d-6.2143035625997936!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f6adbd77af01%3A0x23abed373d7987d2!2sBalai%20Sidang%20Jakarta%20Convention%20Center!5e0!3m2!1sid!2sid!4v1657174420181!5m2!1sid!2sid',
            'start_datetime' => '2022-06-22 10:00:00',
            'end_datetime' => '2022-06-26 21:00:00',
            'description' => '<p style="text-align:justify;"><span style="background-color:rgb(251,251,251);color:rgb(73,74,74);">Pameran INDOCOMTECH 2022 merupakan pameran IT , Gadget dan perlengkapan pendukungnya, Indocomtech memungkinkan anda terhubung langsung dengan para teknologi antusias, tanpa membatasi keberadaan Anda dengan para pelanggan. Temukan kesempatan untuk memaksimalkan platform digital &amp; social media Anda di Indocomtech untuk terhubung langsung dengan para antusias</span></p>',
            'thumbnail' => 'upload/event_thumbnail/1h5lRhmcj2xBFSb26tG5gaS0kUz8dZSxUAqLQmh4.png',
            'file' => 'upload/event_file/1h5lRhmcj2xBFSb26tG5gaS0kUz8dZSxUAqLQmh4.png',
            'is_accepted' => true,
        ]);

        Event::create([
            'organizer_users_id' => 2,
            'category_event_categories_id' => 2,
            'title' => 'Founder Session #1 “Comparing UI/UX Tools”',
            'slug' => 'founder-session-1-comparing-uiux-tools',
            'location' => 'https://bit.ly/foundersessionfeb2021',
            'start_datetime' => '2020-02-15 15:30:00',
            'end_datetime' => '2020-02-15 17:00:00',
            'description' => '<p style="text-align:justify;">Siapa disini yang udah kangen banget pengen ikutan Founder Session. Setelah absen di bulan kemarin, bulan ini founder session hadir kembali nih, kita bakalan ngobrol seru tentang “Comparing Ui/Ux Tools”.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Yuk biar lebih pinter ikutan Founder Session yang akan diadakan JDV pada :<br>🗓️ Senin, 15 Februari 2021<br>🕓 15.30 – 17.00 WIB</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Jangan lupa untuk mendaftarkan dirimu pada bit.ly/foundersessionfeb2021 ya!</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">See you there 👋</p>',
            'thumbnail' => 'upload/event_thumbnail/1h5lRhmcj2xBFSb26tG5gaS0kUz8dZSxUAqLQmh4.png',
            'is_accepted' => true,
        ]);
        
        Event::create([
            'organizer_users_id' => 2,
            'category_event_categories_id' => 9,
            'title' => 'Startup Hub #8 – “February” Local Pitch',
            'slug' => 'startup-hub-8-–-february-local-pitch',
            'location' => 'bit.ly/localpitchjdv2021',
            'start_datetime' => '2022-02-16 10:00:00',
            'end_datetime' => '2022-02-16 13:00:00',
            'description' => '<p style="text-align:justify;">Halo JDVers,</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">StartUp HUB segera hadir lagi nih!</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Udah tau belum StartUp HUB itu apa?<br>Jadiii.. StartUp HUB adalah program pendampingan startup yang diadakan oleh Jogja Digital Valley, yang berupa local pitch serta coaching.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Nah, startup yang terpilih akan berkesempatan untuk mengikuti national pitch dengan digital valley lainnya.<br>Yuk ikutan StartUp HUB dan perbesar peluangmu gabung ke Indigo!</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Benefit ikutan StartUp HUB:<br>√ One on One Coaching<br>√ StartUp Community<br>√ Network<br>√ Engagement<br>√ Private Room Access</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Kapan sih acaranya?<br>🗓️ Selasa, 16 Februari 2021<br>🕙 pukul 10.00 – Selesai<br>📍Live Stream<br>Syarat:<br>• Sudah memiliki product dan prototype (MVP)<br>• Sudah masuk di tahapan Product Validation &amp; melewati tahapan Customer Validation</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Kalian bisa daftar StartUp HUB di <a href="https://bit.ly/localpitchjdv2021">bit.ly/localpitchjdv2021</a><br>paling lambat tanggal 14 Februari 2021</p>',
            'thumbnail' => 'upload/event_thumbnail/1h5lRhmcj2xBFSb26tG5gaS0kUz8dZSxUAqLQmh4.png',
            'file' => 'upload/event_file/1h5lRhmcj2xBFSb26tG5gaS0kUz8dZSxUAqLQmh4.png',
            'is_accepted' => true,
        ]);
        
        Event::create([
            'organizer_users_id' => 2,
            'category_event_categories_id' => 10,
            'title' => 'Founder Session #12 “GIS & BIM Innovation with Augmented Reality”',
            'slug' => 'founder-session-12-gis-and-bim-innovation-with-augmented-reality',
            'location' => 'https://bit.ly/fsdesember2020',
            'start_datetime' => '2020-12-15 15:30:00',
            'end_datetime' => '2020-12-15 17:00:00',
            'description' => '<p style="text-align:justify;">Hii JDVers!</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Founder Session hadir kembali nih di bulan penghujung tahun.<br>Nah kali ini kami akan menyelenggarakan Founder Session dengan mengangkat tema “GIS &amp; BIM Innovation with Augmented Reality”.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Topik ini akan dibawakan oleh pembicara yang pastinya sudah ahli pada bidang tersebut yaitu Saudara Agastya Widhi. Selain itu, Founder Session cocok banget bagi kamu yang ingin membuat atau sedang bergerak dalam dunia startup. BIM (Building Information Modeling) dan GIS (Geographic Information System) adalah dua teknologi penting, yang integrasinya dapat membawa hasil yang patut dicontoh ke dalam konstruksi digital.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Yuk.. tunggu apa lagi?<br>Event ini pastinya seru banget dan bisa menambah insight kita dalam dunia Start up loh terutama.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Ikuti acaranya pada :<br>📅 Selasa, 15 Desember 2020<br>🕜 15.30 – 17.00 WIB</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Jangan lupa daftarkan dirimu di bit.ly/fsdesember2020 ya 😉</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Kami tunggu yah kehadiran kalian bersama kami! Sampai jumpa…</p>',
            'thumbnail' => 'upload/event_thumbnail/1h5lRhmcj2xBFSb26tG5gaS0kUz8dZSxUAqLQmh4.png',
            'is_accepted' => true,
        ]);
    }
}
