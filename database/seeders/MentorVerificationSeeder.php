<?php

namespace Database\Seeders;

use App\Models\MentorVerification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MentorVerificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MentorVerification::create([
            'sender_users_id' => 2,
            'profile_summary' => '<p style="text-align:justify;">Saya adalah seorang mahasiswa yang sekarang berkuliah di Institut Teknologi Del.</p><p style="text-align:justify;">Saya sering mengerjakan proyek dalam bentuk sebuah Website untuk keperluan tugas kampus ataupun untuk seseorang.</p><p style="text-align:justify;">Selain Website, kini juga saya sedang mempelajari Mobile Apps Development khususnya di bidang Android.</p>',
            'id_card' => 'upload/mentor_verification_id_card/tchBvKC3FO4Z2FB2P7Ja5zf8chDlzdPal12sM7Me.jpeg',
            'selfie_with_id_card' => 'upload/mentor_verification_selfie_with_id_card/KD8uFr8iZGHzrhrEbqtET9BOB1mibZXVr8at9zIn.jpeg',
            'resume' => 'upload/mentor_verification_resume/OqOZOb6ijcG3YJz84ZQMsjYGn7sACeokVAcIzOTB.txt',
            'whatsapp_number' => '628116120030',
            'facebook_profile_link' => 'https://facebook.com/gahasapurba',
            'instagram_profile_link' => 'https://instagram.com/gahasapurba',
            'linkedin_profile_link' => 'https://linkedin.com/in/gahasapurba',
            'bank_account_number' => '109601033440508',
            'bank_account_name' => 'Gahasa Timotius Purba',
            'bank_name' => 'BRI',
            'is_accepted' => true,
        ]);
    }
}
