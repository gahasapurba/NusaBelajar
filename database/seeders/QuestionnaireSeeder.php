<?php

namespace Database\Seeders;

use App\Models\Questionnaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionnaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Questionnaire::create([
            'name' => 'Edwin Damanik',
            'email' => 'edwindamanik5@gmail.com',
            'answer1' => 'Sangat Bermanfaat',
            'answer2' => 'Sangat Lengkap',
            'answer3' => 'Sangat Bermanfaat',
            'answer4' => 'Sangat Berkualitas',
            'testimonial' => 'Belajar di NusaBelajar sangat bermanfaat untuk para pelajar yang ingin belajar hal baru. Terima kasih NusaBelajar',
        ]);
        
        Questionnaire::create([
            'name' => 'Evelin Sinurat',
            'email' => 'evelinsinurat23@gmail.com',
            'answer1' => 'Sangat Bermanfaat',
            'answer2' => 'Sangat Lengkap',
            'answer3' => 'Sangat Bermanfaat',
            'answer4' => 'Sangat Berkualitas',
            'testimonial' => 'Dengan belajar di NusaBelajar, saya menjadi lebih pintar dan bersemangat dalam belajar. Terima kasih NusaBelajar',
        ]);
        
        Questionnaire::create([
            'name' => 'Gahasa Purba',
            'email' => 'gahasapurba.edu@gmail.com',
            'answer1' => 'Sangat Bermanfaat',
            'answer2' => 'Sangat Lengkap',
            'answer3' => 'Sangat Bermanfaat',
            'answer4' => 'Sangat Berkualitas',
            'testimonial' => 'Materi pelajaran yang ada di NusaBelajar sangat lengkap dan bermanfaat. Terima kasih NusaBelajar',
        ]);
        
        Questionnaire::create([
            'name' => 'Geby Lumban Gaol',
            'email' => 'gebygaol6701@gmail.com',
            'answer1' => 'Sangat Bermanfaat',
            'answer2' => 'Sangat Lengkap',
            'answer3' => 'Sangat Bermanfaat',
            'answer4' => 'Sangat Berkualitas',
            'testimonial' => 'Dengan adanya forum diskusi di NusaBelajar, saya merasa sangat terbantu apabila ada sesuatu hal yang ingin saya tanyakan. Terima kasih NusaBelajar',
        ]);
        
        Questionnaire::create([
            'name' => 'Lastri Nababan',
            'email' => 'lastrinababan838@gmail.com',
            'answer1' => 'Sangat Bermanfaat',
            'answer2' => 'Sangat Lengkap',
            'answer3' => 'Sangat Bermanfaat',
            'answer4' => 'Sangat Berkualitas',
            'testimonial' => 'NusaBelajar merupakan platform yang telah ikut mencerdaskan anak bangsa. Terima kasih NusaBelajar',
        ]);
        
        Questionnaire::create([
            'name' => 'Malino Sihotang',
            'email' => 'malinosihotang175@gmail.com',
            'answer1' => 'Sangat Bermanfaat',
            'answer2' => 'Sangat Lengkap',
            'answer3' => 'Sangat Bermanfaat',
            'answer4' => 'Sangat Berkualitas',
            'testimonial' => 'Artikel-artikel yang ada di Blog NusaBelajar cukup menarik untuk dibaca karena dapat menambah ilmu baru. Terima kasih NusaBelajar',
        ]);
        
        Questionnaire::create([
            'name' => 'Yonatan Tobing',
            'email' => 'yonatanaplt@gmail.com',
            'answer1' => 'Sangat Bermanfaat',
            'answer2' => 'Sangat Lengkap',
            'answer3' => 'Sangat Bermanfaat',
            'answer4' => 'Sangat Berkualitas',
            'testimonial' => 'Dengan adanya platform pembelajaran seperti NusaBelajar, membuat saya bisa belajar darimana saja dan kapan saja. Terima kasih NusaBelajar',
        ]);
    }
}
