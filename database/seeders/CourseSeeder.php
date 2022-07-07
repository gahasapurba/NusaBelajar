<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::create([
            'mentor_users_id' => 2,
            'category_course_categories_id' => 7,
            'title' => 'Full-Stack Laravel Flutter: Build e-Wallet Mobile Apps',
            'slug' => 'full-stack-laravel-flutter-build-e-wallet-mobile-apps',
            'price' => 329000,
            'description' => '<p style="text-align:justify;">Secara garis besar, pertumbuhan aplikasi mobile terus mengalami peningkatan dari tahun ke tahun. Saat ini, ada lebih dari 2,5 juta aplikasi yang berbeda dan dapat diunduh secara bebas di Google PlayStore. Jumlah yang sangat besar bukan? Nah, framerowk Flutter dan Laravel adalah dua framework yang sangat populer untuk membangun aplikasi berbasis mobile. Pada kelas ini, kamu akan menggunakan keduanya untuk membangun aplikas e-Wallet.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Karena kamu akan mempelajari dua framework, maka dua mentor yang ahli pada bidangnya masing-masing, Widada dan Rifqi, akan mendampingimu selama pembelajaran berlangsung. Dengan membangun aplikasi e-Wallet, kamu akan mempelajari berbagai hal, mulai dari slicing Figma dengan Flutter sampai membangun CMS dengan dengan Laravel, dan tentunya masih banyak lagi. Pada akhirnya, aplikasi e-Wallet tersebut dapat menjadi portofoliomu yang siap untuk digunakan.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Kelas ini sangat sesuai untuk kamu yang ingin meningkatkan kemampuanmu dalam hal Software Development ke advanced level karena materi yang diberikan cukup lengkap. Tunggu apa lagi? Segera bergabung dan selamat belajar ya!</p>',
            'thumbnail' => 'upload/course_thumbnail/FPZzkj2kBPzuYaJAhr4yWYpMYSJfesrREm1fKBVK.png',
            'introduction_youtube_video_link' => 'https://youtu.be/DXAQoc7gt8w',
            'telegram_group_link' => 'https://t.me/Bash_ID',
            'syllabus' => 'upload/course_syllabus/IcroKwEwkrZFhstajvzKDhydAolj335lprLq5iqY.txt',
            'is_accepted' => true,
            'is_featured' => true,
        ]);
        
        Course::create([
            'mentor_users_id' => 2,
            'category_course_categories_id' => 6,
            'title' => 'Full-Stack Developer with Laravel: Web Travel',
            'slug' => 'full-stack-developer-with-laravel-web-travel',
            'price' => 280000,
            'description' => '<p style="text-align:justify;">Pada kelas ini, kita akan mempelajari Full-Stack Web Developer bersama mentor Galih dengan studi kasus membuat Website Travel. Akan ada banyak hal yang kita pelajari serta ada berbagai tools yang akan kita gunakan. Diawali dengan slicing website menggunakan Bootstrap, kemudian dilanjutkan dengan membangun bagian Backend menggunakan PHP dan Laravel Framework. Pada akhirnya, kita akan melakukan website deployment ke server.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Selama kelas berlangsung, kita juga akan mempelajari berbagai hal seperti Integrasi midtrans, membuat email konfirmasi, dan masih banyak lagi. Kelas ini sangat&nbsp; sesuai untuk kamu yang ingin berkarir sebagai Full-Stack Web Developer dan untuk kamu yang masih bimbang memilih Front-End ataupun Back-End, karena di kelas ini kita akan berkenalan dengan keduanya.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Tunggu apalagi? Segera bergabung dan selesaikan project akhirnya sehingga kamu bisa memiliki portofolio yang berkelas. Selamat belajar ya!</p>',
            'thumbnail' => 'upload/course_thumbnail/FPZzkj2kBPzuYaJAhr4yWYpMYSJfesrREm1fKBVK.png',
            'introduction_youtube_video_link' => 'https://youtu.be/5NnitccphIM',
            'telegram_group_link' => 'https://t.me/bashidorg',
            'syllabus' => 'upload/course_syllabus/IcroKwEwkrZFhstajvzKDhydAolj335lprLq5iqY.txt',
            'file' => 'upload/course_file/IcroKwEwkrZFhstajvzKDhydAolj335lprLq5iqY.txt',
            'is_accepted' => true,
            'is_featured' => true,
        ]);
        
        Course::create([
            'mentor_users_id' => 2,
            'category_course_categories_id' => 2,
            'title' => 'Complete Freelancer UI/UX & Illustration Designer: Brief, Wireframe, Visual Design, Portfolio',
            'slug' => 'complete-freelancer-uiux-and-illustration-designer-brief-wireframe-visual-design-portfolio',
            'price' => 249000,
            'description' => '<p style="text-align:justify;">Banyak sekali keuntungan saat kamu bekerja sebagai freelancer UI Designer atau UI Illustrator. Mulai dari waktu dan tempat kerja yang fleksibel, beban kerja yang dapat kamu atur sendiri, hingga sumber income yang bisa lebih dari satu. Bagaimana, menarik bukan? Namun, memulai untuk menjadi freelancer bukanlah hal yang mudah. Maka dari itu, kami menghadirkan kelas ini sebagai bekal kamu untuk mempersiapkan diri menjadi freelancer profesional.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Bersama mentor Angga dan Beatrice, kamu akan mempelajari UI Design plus UI Illustration dengan hasil akhir project design sebuah website. Dengan mempelajari cara memahami brief client berdasarkan request yang diberikan, dan mempelajari cara berkolaborasi dengan designer lainnya, kamu akan memahami design process lebih baik lagi. Ohya, setelah project selesai, kamu juga akan belajar bagaimana memasarkan karyamu mulai dari menguploadnya pada dribble hingga listing jasa di upwork.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Kelas ini sangat sesuai untuk mempelajari UI Design, Illustration dan Freelance. Silahkan bergabung dan siapkan dirimu untuk mengeksplorasi dunia UI Freelancer!</p>',
            'thumbnail' => 'upload/course_thumbnail/FPZzkj2kBPzuYaJAhr4yWYpMYSJfesrREm1fKBVK.png',
            'introduction_youtube_video_link' => 'https://youtu.be/yTsl4w1a_4o',
            'telegram_group_link' => 'https://t.me/GNURIndonesia',
            'syllabus' => 'upload/course_syllabus/IcroKwEwkrZFhstajvzKDhydAolj335lprLq5iqY.txt',
            'is_accepted' => true,
            'is_featured' => true,
        ]);
        
        Course::create([
            'mentor_users_id' => 2,
            'category_course_categories_id' => 7,
            'title' => 'SwiftUI & iOS Engineer: The Complete App Development Bootcamp',
            'slug' => 'swiftui-and-ios-engineer-the-complete-app-development-bootcamp',
            'price' => 123456,
            'description' => '<p style="text-align:justify;">Di era digital, berbagai perusahaan berlomba untuk mengembangkan situs web dan aplikasi yang user friendly dan responsif. Oleh karena itu, berbagai pekerjaan seputar design dan development sangat dibutuhkan saat ini. Jika kamu menyukai bagaimana melakukan slicing UI ke dalam UI/UX Development, profesi Junior UI/UX Developer atau yang lebih dikenal dengan UI Engineer akan menjadi profesi yang ideal untukmu.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Melalui kelas ini, kamu akan berperan sebagai UI Engineer untuk melakukan slicing Food App design dari Figma menggunakan aplikasi Xcode, development tools untuk aplikasi berbasis iOS. Nantinya, mentor Angga tidak hanya akan memberikan panduan untuk melakukan slicing, namun juga akan ada challange untuk kamu melakukan slicing sendiri. Namun jangan khawatir, di akhir kelas kamu bisa mencocokan bagiamana cara kamu dan mentor dalam melakukan slicing page tersebut.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Silahkan bergabung untuk upgrade skill slicing kamu dan mendapatkan sertifikat resminya setelah kamu menyelesaikan kelas. Okay people with the spirit of learning semoga bermanfaat dan kami tunggu di kelas ya!</p>',
            'thumbnail' => 'upload/course_thumbnail/FPZzkj2kBPzuYaJAhr4yWYpMYSJfesrREm1fKBVK.png',
            'introduction_youtube_video_link' => 'https://youtu.be/K2QnGe4nhIk',
            'telegram_group_link' => 'https://t.me/BelajarGolangMariaDB',
            'syllabus' => 'upload/course_syllabus/IcroKwEwkrZFhstajvzKDhydAolj335lprLq5iqY.txt',
            'file' => 'upload/course_file/IcroKwEwkrZFhstajvzKDhydAolj335lprLq5iqY.txt',
            'is_accepted' => true,
            'is_featured' => true,
        ]);
        
        Course::create([
            'mentor_users_id' => 2,
            'category_course_categories_id' => 2,
            'title' => 'Learn Adobe Photoshop CC For Essentials Training',
            'slug' => 'learn-adobe-photoshop-cc-for-essentials-training',
            'price' => 75000,
            'description' => '<p style="text-align:justify;">Photoshop adalah salah satu produk Adobe yang sering digunakan untuk kebutuhan design banner, brochure, business card, wedding photos, dan bahkan juga kepada UI/UX. Pada kelas ini kita akan belajar bersama bagaimana caranya mendesign sebuah postingan Instagram yang akan digunakan untuk promosi jual beli properti (rumah, apartment, dan hotel).</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Sehingga nantinya ketika selesai belajar dari kelas ini, kita memiliki gambaran luas tentang bagaimana menggunakan Photoshop dengan baik dan mengerjakan projek sesuai dari brief klien atau perusahaan tempat kita bekerja nantinya sebagai graphic designer.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Silahkan bergabung bersama dengan mentor Angga untuk memperdalam software Photoshop CC terbaru.</p>',
            'thumbnail' => 'upload/course_thumbnail/FPZzkj2kBPzuYaJAhr4yWYpMYSJfesrREm1fKBVK.png',
            'introduction_youtube_video_link' => 'https://youtu.be/RcaUrSrqDnM',
            'telegram_group_link' => 'https://t.me/belajarhtmlcss',
            'syllabus' => 'upload/course_syllabus/IcroKwEwkrZFhstajvzKDhydAolj335lprLq5iqY.txt',
            'is_accepted' => true,
            'is_featured' => true,
        ]);
        
        Course::create([
            'mentor_users_id' => 2,
            'category_course_categories_id' => 2,
            'title' => 'Mastering Blender 3D: Design Icon Set',
            'slug' => 'mastering-blender-3d-design-icon-set',
            'price' => 355000,
            'description' => '<p style="text-align:justify;">Di tahun 2021 ini banyak sekali UI Designer yang mengadopsi trend terbaru untuk mendesain sebuah User-Interface dengan menggunakan 3D object. Salah satu cara membuatnya adalah dengan menggunakan software Blender 3D yang bisa digunakan secara gratis oleh siapa saja.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Dalam kelas ini kita akan memperdalam software Blender 3D untuk mendesain Icon Set yang nantinya bisa kita jual juga di beberapa tempat seperti Marketplace. Kelas ini akan kita mulai dengan memahami dan membuat sketsa yang selanjutnya akan ditransformasi menjadi bentuk 3D menggunakan software Blender 3D.</p><p style="text-align:justify;">&nbsp;</p><p style="text-align:justify;">Apabila kamu siap untuk mengikuti trend baru di dalam dunia design maka kelas ini cocok untuk dipelajari sedari sekarang dan kami akan tunggu kalian di kelas ya.</p>',
            'thumbnail' => 'upload/course_thumbnail/FPZzkj2kBPzuYaJAhr4yWYpMYSJfesrREm1fKBVK.png',
            'introduction_youtube_video_link' => 'https://youtu.be/0QeUFQRtv3s',
            'telegram_group_link' => 'https://t.me/Diskusiantarbahasaprograman',
            'syllabus' => 'upload/course_syllabus/IcroKwEwkrZFhstajvzKDhydAolj335lprLq5iqY.txt',
            'file' => 'upload/course_file/IcroKwEwkrZFhstajvzKDhydAolj335lprLq5iqY.txt',
            'is_accepted' => true,
            'is_featured' => true,
        ]);
    }
}
