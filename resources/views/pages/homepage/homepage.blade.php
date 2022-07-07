@extends('layouts.homepage')
@section('title')
    Beranda
@endsection
@section('content')
<section class="hero-area">
    <div class="hero-slider">
        <div class="hero-inner overlay" style="background-image: url('/assets/homepage/images/hero/slider-bg1.jpg');">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-8 offset-lg-2 col-md-12 co-12">
                        <div class="home-slider">
                            <div class="hero-text">
                                <h5 class="wow fadeInUp" data-wow-delay=".3s">#MencerdaskanIndonesia</h5>
                                <h1 class="wow fadeInUp" data-wow-delay=".5s">Belajar Untuk Masa Depan<br>Dari Manapun dan Kapanpun</h1>
                                <p class="wow fadeInUp" data-wow-delay=".7s">Melalui NusaBelajar, kita dapat tetap belajar hal baru dari manapun dan kapanpun kita mau<br>Dengan banyaknya kelas yang dapat dipelajari, anda dapat mempersiapkan diri<br>untuk masa depan yang lebih gemilang</p>
                                <div class="button wow fadeInUp" data-wow-delay=".9s">
                                    <a href="{{ route('aboutus.index') }}" class="btn">Tentang Kami</a>
                                    <a href="{{ route('course.index') }}" class="btn alt-btn">Lihat Kelas</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-inner overlay" style="background-image: url('/assets/homepage/images/hero/slider-bg2.jpg');">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-8 offset-lg-2 col-md-12 co-12">
                        <div class="home-slider">
                            <div class="hero-text">
                                <h5 class="wow fadeInUp" data-wow-delay=".3s">#MencerdaskanIndonesia</h5>
                                <h1 class="wow fadeInUp" data-wow-delay=".5s">Kami Selalu Ada<br>Untuk Setiap Kesulitanmu</h1>
                                <p class="wow fadeInUp" data-wow-delay=".7s">Dengan adanya forum diskusi di NusaBelajar, anda tidak perlu khawatir lagi<br>akan setiap kesulitan yang anda hadapi dalam proses pembelajaran<br>Anda dapat berdiskusi dengan pengguna lainnya atau juga dengan para mentor NusaBelajar<br>yang akan selalu hadir untuk anda apabila ada hal yang ingin anda tanyakan terkait sebuah pembelajaran</p>
                                <div class="button wow fadeInUp" data-wow-delay=".9s">
                                    <a href="{{ route('contact.create') }}" class="btn">Hubungi Kami</a>
                                    <a href="{{ route('discussion.index') }}" class="btn alt-btn">Lihat Forum Diskusi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-inner overlay" style="background-image: url('/assets/homepage/images/hero/slider-bg3.jpg');">
            <div class="container">
                <div class="row ">
                    <div class="col-lg-8 offset-lg-2 col-md-12 co-12">
                        <div class="home-slider">
                            <div class="hero-text">
                                <h5 class="wow fadeInUp" data-wow-delay=".3s">#MencerdaskanIndonesia</h5>
                                <h1 class="wow fadeInUp" data-wow-delay=".5s">Dapatkan Inspirasi<br>Melalui Bacaan Yang Berkualitas</h1>
                                <p class="wow fadeInUp" data-wow-delay=".7s">Membaca adalah metode yang ampuh untuk mendapatakan sebuah inspirasi<br>Dalam blog di website NusaBelajar anda akan menemukan berbagai artikel pengetahuan<br>yang berkualitas untuk anda dapatkan secara gratis</p>
                                <div class="button wow fadeInUp" data-wow-delay=".9s">
                                    <a href="{{ route('questionnaire.create') }}" class="btn">Isi Kuesioner</a>
                                    <a href="{{ route('article.index') }}" class="btn alt-btn">Lihat Blog</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="features style2">
    <div class="container-fluid">
        <div class="single-head">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12 padding-zero">
                    <div class="single-feature">
                        <h3>
                            <a href="{{ route('event.index') }}">Event</a>
                        </h3>
                        <p style="text-align: justify">Anda dapat mengikuti event-event seperti webinar, workshop, dan event-event lainnya yang diselenggarakan NusaBelajar bersama para mentor-mentor yang ada di website NusaBelajar</p>
                        <div class="button">
                            <a href="{{ route('event.index') }}" class="btn">Lihat Event <i class="lni lni-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 padding-zero">
                    <div class="single-feature">
                        <h3>
                            <a href="{{ route('discount.index') }}">Promo</a>
                        </h3>
                        <p style="text-align: justify">Berbagai penawaran menarik kami tawarkan kepada anda sebagai bentuk terima kasih kami untuk anda yang telah menjadi bagian dari NusaBelajar</p>
                        <div class="button">
                            <a href="{{ route('discount.index') }}" class="btn">Lihat Promo <i class="lni lni-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 padding-zero">
                    <div class="single-feature">
                        <h3>
                            <a href="{{ route('discussion.index') }}">Forum Diskusi</a>
                        </h3>
                        <p style="text-align: justify">Anda dapat berdiskusi dengan pengguna lainnya atau juga dengan para mentor NusaBelajar yang akan selalu hadir untuk anda apabila ada hal yang ingin anda tanyakan terkait sebuah pembelajaran</p>
                        <div class="button">
                            <a href="{{ route('discussion.index') }}" class="btn">Lihat Forum Diskusi <i class="lni lni-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 padding-zero">
                    <div class="single-feature last">
                        <h3>
                            <a href="{{ route('article.index') }}">Blog</a>
                        </h3>
                        <p style="text-align: justify">Dalam blog di website NusaBelajar anda akan menemukan berbagai artikel pengetahuan yang berkualitas untuk anda dapatkan secara gratis</p>
                        <div class="button">
                            <a href="{{ route('article.index') }}" class="btn">Lihat Blog <i class="lni lni-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="experience section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="left-content">
                    <div class="exp-title align-left">
                        <span class="wow fadeInDown" data-wow-delay=".2s">Fakta Tentang Kami</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">Kami menyediakan sarana untuk belajar<br>dari manapun dan kapanpun</h2>
                        <p class="wow fadeInUp" data-wow-delay=".6s">NusaBelajar hadir sebagai platform pembelajaran online yang dapat diakses oleh setiap masyarakat Indonesia tanpa batasan ruang dan waktu demi #MencerdaskanIndonesia</p>
                        <div class="button wow fadeInUp" data-wow-delay="1s">
                            <a href="about-us.html" class="btn">Info Selengkapnya</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="image wow fadeInRight" data-wow-delay="0.5s">
                    <img src="{{ asset('assets/homepage/images/experience/experience.jpg') }}" alt="Experience">
                    <h2>
                        1 <span class="year">tahun</span> <span class="work">Hadir Di Indonesia</span>
                    </h2>
                </div>
            </div>
        </div>
        <div class="cta-mini">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-md-12 col-12">
                    <p>Temukan berbagai mentor yang dapat membimbing anda dalam setiap proses pembelajaran di website NusaBelajar <a href="{{ route('mentor.verification.index') }}">Lihat Mentor</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="about-us section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="about-left">
                    <div class="about-title align-left">
                        <span class="wow fadeInDown" data-wow-delay=".2s">#MencerdaskanIndonesia</span>
                        <h2 class="wow fadeInUp" data-wow-delay=".4s">NusaBelajar & Institut Teknologi Del</h2>
                        <p class="wow fadeInUp" style="text-align: justify" data-wow-delay=".6s">NusaBelajar hadir sebagai platform pembelajaran online yang dapat diakses oleh setiap masyarakat Indonesia tanpa batasan ruang dan waktu. Platform NusaBelajar menawarkan berbagai materi pembelajaran yang siap memberikan ilmu bagi setiap orang.</p>
                        <p class="qote wow fadeInUp" style="text-align: justify" data-wow-delay="0.5s">NusaBelajar juga tidak lepas kaitannya dengan Institut Teknologi Del. Institut Teknologi Del adalah sebuah Institut berbasis Teknologi yang terletak di Sumatera Utara tepatnya di pingggiran Danau Toba. Kampus ini berhasil melahirkan inovasi-inovasi baru dalam hal pengembangan teknologi digital termasuk platform ini yang menjadi karya dari beberapa Mahasiswa Prodi D4 TRPL 19 yang berasal dari kampus ini</p>
                        <div class="button wow fadeInUp" data-wow-delay="1s">
                            <a href="{{ route('aboutus.index') }}" class="btn">Tentang Kami</a>
                            <a href="https://youtu.be/oW9s-3k-PGU" class="glightbox video btn">Putar Video<i class="lni lni-play"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="about-right wow fadeInRight" data-wow-delay=".4s">
                    <img src="{{ asset('assets/homepage/images/about/about-img2.png') }}" alt="Institut Teknologi Del">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="courses style2 section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <span class="wow zoomIn" data-wow-delay="0.2s">Kelas NusaBelajar</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Kelas Terbaik Untuk Anda</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Ada banyak kelas yang tersedia di website NusaBelajar untuk anda pelajari demi mendapatkan ilmu pengetahuan yang baru dan berkualitas</p>
                </div>
            </div>
        </div>
        <div class="single-head">
            <div class="row justify-content-center">
                @forelse ($featured_courses as $featured_course)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-course wow fadeInUp" data-wow-delay=".2s">
                            <div class="course-image">
                                <a href="{{ route('course.show', $featured_course->slug) }}"><img src="{{ Storage::url($featured_course->thumbnail) }}" alt="Thumbnail"></a>
                            </div>
                            <div class="content">
                                <p class="price">{{ $featured_course->course_category->name }}</p>
                                <p class="date">Rp{{ number_format($featured_course->price, 2, ',', '.') }}</p>
                                <p class="date">{{ $featured_course->created_at->isoFormat('D MMMM, Y') }}</p>
                                <h3>
                                    <a href="{{ route('course.show', $featured_course->slug) }}">{{ $featured_course->title }}</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-course wow fadeInUp" data-wow-delay=".2s">
                            <div class="content">
                                <h3 class="text-center">
                                    <a href="#">Tidak Ada Kelas</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="button">
                        <a href="{{ route('course.index') }}" class="btn">Lihat Semua Kelas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="mission">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <span class="wow zoomIn" data-wow-delay="0.2s">Visi & Misi Kami</span>
                    <p class="wow fadeInUp" data-wow-delay=".6s">“Belajar adalah hak semua orang untuk menjadi bagian yang terbaik dari dirinya agar dapat bermanfaat bagi sesama”</p>
                    <img src="{{ asset('assets/homepage/images/signeture/signeture.png') }}" alt="Signeture">
                </div>
            </div>
        </div>
    </div>
</div>
<section class="our-achievement style3 section overlay">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-12">
                <div class="single-achievement wow fadeInUp" data-wow-delay=".2s">
                    <h3 class="counter"><span id="secondo1" class="countup" cup-end="{{ $user_count }}">{{ $user_count }}</span></h3>
                    <h4>Pengguna</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <div class="single-achievement wow fadeInUp" data-wow-delay=".4s">
                    <h3 class="counter"><span id="secondo2" class="countup" cup-end="{{ $course_count }}">{{ $course_count }}</span></h3>
                    <h4>Kelas</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <div class="single-achievement wow fadeInUp" data-wow-delay=".6s">
                    <h3 class="counter"><span id="secondo3" class="countup" cup-end="{{ $article_count }}">{{ $article_count }}</span></h3>
                    <h4>Artikel</h4>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-12">
                <div class="single-achievement wow fadeInUp" data-wow-delay=".6s">
                    <h3 class="counter"><span id="secondo3" class="countup" cup-end="{{ $discussion_count }}">{{ $discussion_count }}</span></h3>
                    <h4>Diskusi</h4>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="services section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <span class="wow zoomIn" data-wow-delay="0.2s">Apa Yang Kami Tawarkan</span>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Pembelajaran Berkualitas</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Ada berbagai macam layanan yang kami tawarkan di website ini yang dapat kami jamin kualitasnya demi proses pembelajaran yang bermanfaat</p>
                </div>
            </div>
        </div>
        <div class="single-head">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".2s">
                        <span class="icon"><i class="lni lni-agenda"></i></span>
                        <h3>
                            <a href="{{ route('course.index') }}">Kelas Berkualitas</a>
                        </h3>
                        <p>Dengan banyaknya kelas berkualitas yang dapat dipelajari, anda dapat mempersiapkan diri untuk masa depan yang lebih gemilang</p>
                        <div class="button">
                            <a href="{{ route('course.index') }}" class="btn">Lihat Kelas</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".4s">
                        <span class="icon"><i class="lni lni-book"></i></span>
                        <h3>
                            <a href="{{ route('article.index') }}">Artikel Bermanfaat</a>
                        </h3>
                        <p>Dalam blog di website NusaBelajar anda akan menemukan berbagai artikel pengetahuan yang bermanfaat untuk anda dapatkan secara gratis</p>
                        <div class="button">
                            <a href="{{ route('article.index') }}" class="btn">Lihat Blog</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-service wow fadeInUp" data-wow-delay=".6s">
                        <span class="icon"><i class="lni lni-consulting"></i></span>
                        <h3>
                            <a href="{{ route('mentor.verification.index') }}">Mentor Berpengalaman</a>
                        </h3>
                        <p>Mentor-mentor kami yang telah berpengalaman akan selalu siap sedia membantu anda selama proses pembelajaran anda di NusaBelajar</p>
                        <div class="button">
                            <a href="{{ route('mentor.verification.index') }}" class="btn">Lihat Mentor</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="work-process section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-12">
                <div class="section-title align-center gray-bg">
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Bagaimana Proses Belajar di NusaBelajar?</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Kami menawarkan berbagai kelas dengan materi yang beragam dan tentunya dapat anda pelajari melalui website NusaBelajar</p>
                </div>
            </div>
        </div>
        <div class="list">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12">
                    <ul class="wow fadeInUp" data-wow-delay=".2s">
                        <li>
                            <span class="serial">1</span>
                            <p class="content"><span>Pilih Kelas</span>Anda dapat memilih kelas mana yang hendak anda pelajari sesuai dengan minta dan kemampuan anda</p>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <ul class="wow fadeInUp" data-wow-delay=".4s">
                        <li>
                            <span class="serial">2</span>
                            <p class="content"><span>Beli Kelas</span>Setelah itu, anda dapat membeli kelas yang telah anda pilih. Dengan ini anda juga telah mendukung kami untuk menghadirkan NusaBelajar yang lebih baik lagi</p>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <ul class="wow fadeInUp" data-wow-delay=".6s">
                        <li>
                            <span class="serial">3</span>
                            <p class="content"><span>Mulai Belajar</span>Apabila anda sudah membeli kelas, mentor akan mendaftarkan anda ke kelas yang anda beli dan anda dapat mulai belajar</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="events section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <div class="section-icon wow zoomIn" data-wow-delay=".4s">
                        <i class="lni lni-bookmark"></i>
                    </div>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Event Terbaru</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Ada berbagai event bermanfaat yang ditampilkan di website NusaBelajar yang dapat anda ikuti</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @forelse ($latest_events_with_thumbnail as $latest_event_with_thumbnail)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-event wow fadeInUp" data-wow-delay=".2s">
                        <div class="event-image">
                            <a href="{{ route('event.show', $latest_event_with_thumbnail->slug) }}"><img src="{{ Storage::url($latest_event_with_thumbnail->thumbnail) }}" alt="Thumbnail"></a>
                            <p class="date">{{ $latest_event_with_thumbnail->start_datetime->isoFormat('D') }}<span>{{ $latest_event_with_thumbnail->start_datetime->isoFormat('MMM') }}</span></p>
                        </div>
                        <div class="content">
                            <h3><a href="{{ route('event.show', $latest_event_with_thumbnail->slug) }}">{{ $latest_event_with_thumbnail->title }}</a></h3>
                            <p>{!! Str::words($latest_event_with_thumbnail->description, 15, '.....') !!}</p>
                        </div>
                        <div class="bottom-content">
                            <a class="speaker" href="#">
                                @if (Str::startsWith($latest_event_with_thumbnail->event_creator->avatar, 'upload/avatar/'))
                                    <img src="{{ Storage::url($latest_event_with_thumbnail->event_creator->avatar) }}" alt="Profile Photo">
                                @elseif (!$latest_event_with_thumbnail->event_creator->avatar)
                                    <img src="https://ui-avatars.com/api/?name={{ $latest_event_with_thumbnail->event_creator->name }}" alt="Profile Photo" />
                                @else
                                    <img src="{{ $latest_event_with_thumbnail->event_creator->avatar }}" alt="Profile Photo" />
                                @endif
                                <span>{{ $latest_event_with_thumbnail->event_creator->name }}</span>
                            </a>
                            <span class="time">
                                <i class="lni lni-timer"></i>
                                <a href="#">{{ $latest_event_with_thumbnail->start_datetime->isoFormat('HH:mm') }} - {{ $latest_event_with_thumbnail->end_datetime->isoFormat('HH:mm') }} WIB</a>
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-event wow fadeInUp" data-wow-delay=".2s">
                        <div class="content">
                            <h3 class="text-center">
                                <a href="#">Tidak Ada Event</a>
                            </h3>
                        </div>
                    </div>
                </div>
            @endforelse
            <div class="col-lg-4 col-md-12 col-12">
                @forelse ($latest_events_without_thumbnail as $latest_event_without_thumbnail)
                    <div class="single-event short wow fadeInUp" data-wow-delay=".6s">
                        <div class="content">
                            <p class="date">25<span>Feb</span></p>
                            <h3>
                                <a href="{{ route('event.show', $latest_event_without_thumbnail->slug) }}">{{ $latest_event_without_thumbnail->title }}</a>
                            </h3>
                            <p>{!! Str::words($latest_event_without_thumbnail->description, 15, '.....') !!}</p>
                        </div>
                        <div class="bottom-content">
                            <a class="speaker" href="#">
                                @if (Str::startsWith($latest_event_without_thumbnail->event_creator->avatar, 'upload/avatar/'))
                                    <img src="{{ Storage::url($latest_event_without_thumbnail->event_creator->avatar) }}" alt="Profile Photo">
                                @elseif (!$latest_event_without_thumbnail->event_creator->avatar)
                                    <img src="https://ui-avatars.com/api/?name={{ $latest_event_without_thumbnail->event_creator->name }}" alt="Profile Photo" />
                                @else
                                    <img src="{{ $latest_event_without_thumbnail->event_creator->avatar }}" alt="Profile Photo" />
                                @endif
                                <span>{{ $latest_event_without_thumbnail->event_creator->name }}</span>
                            </a>
                            <span class="time">
                                <i class="lni lni-timer"></i>
                                <a href="#">{{ $latest_event_without_thumbnail->start_datetime->isoFormat('HH:mm') }} - {{ $latest_event_without_thumbnail->end_datetime->isoFormat('HH:mm') }} WIB</a>
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="single-event short wow fadeInUp" data-wow-delay=".6s">
                        <div class="content">
                            <h3 class="text-center">
                                <a href="#">Tidak Ada Event</a>
                            </h3>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
<section id="teachers" class="teachers section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title align-center gray-bg">
                    <div class="section-icon wow zoomIn" data-wow-delay=".4s">
                        <i class="lni lni-users"></i>
                    </div>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Mentor Berpengalaman Kami</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Ada berbagai mentor di website NusaBelajar yang dapat membimbing anda dalam setiap proses pembelajaran di website NusaBelajar</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @forelse ($mentors as $mentor)
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-team wow fadeInUp" data-wow-delay=".2s">
                        <div class="row">
                            <div class="col-lg-5 col-12">
                                <div class="image">
                                    @if (Str::startsWith($mentor->mentor_verification_creator->avatar, 'upload/avatar/'))
                                        <img src="{{ Storage::url($mentor->mentor_verification_creator->avatar) }}" alt="Profile Photo">
                                    @elseif (!$mentor->mentor_verification_creator->avatar)
                                        <img src="https://ui-avatars.com/api/?name={{ $mentor->mentor_verification_creator->name }}" alt="Profile Photo" />
                                    @else
                                        <img src="{{ $mentor->mentor_verification_creator->avatar }}" alt="Profile Photo" />
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-7 col-12">
                                <div class="info-head">
                                    <div class="info-box">
                                        <h4 class="name">
                                            <a href="{{ route('mentor.verification.show', $hash->encodeHex($mentor->id)) }}">{{ $mentor->mentor_verification_creator->name }}</a>
                                        </h4>
                                        <p>{!! Str::words($mentor->profile_summary, 15, '.....') !!}</p>
                                    </div>
                                    <ul class="social">
                                        <li>
                                            <a href="https://api.whatsapp.com/send?phone={{ $mentor->whatsapp_number }}" target="_blank">
                                                <i class="lni lni-whatsapp"></i>
                                            </a>
                                        </li>
                                        @if($mentor->facebook_profile_link)
                                            <li>
                                                <a href="{{ $mentor->facebook_profile_link }}" target="_blank">
                                                    <i class="lni lni-facebook-original"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if($mentor->instagram_profile_link)
                                            <li>
                                                <a href="{{ $mentor->instagram_profile_link }}" target="_blank">
                                                    <i class="lni lni-instagram-original"></i>
                                                </a>
                                            </li>
                                        @endif
                                        @if($mentor->linkedin_profile_link)
                                            <li>
                                                <a href="{{ $mentor->linkedin_profile_link }}" target="_blank">
                                                    <i class="lni lni-linkedin-original"></i>
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-team wow fadeInUp" data-wow-delay=".2s">
                        <div class="row justify-content-center">
                            <div class="col-lg-7 col-12">
                                <div class="info-head">
                                    <div class="info-box">
                                        <h4 class="name text-center">
                                            <a href="#">Tidak Ada Mentor</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<section class="testimonials section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title align-center gray-bg">
                    <div class="section-icon wow zoomIn" data-wow-delay=".4s">
                        <i class="lni lni-quotation"></i>
                    </div>
                    <h2 class="wow fadeInUp" data-wow-delay=".4s">Apa Kata Pengguna Kami</h2>
                    <p class="wow fadeInUp" data-wow-delay=".6s">Berikut beberapa testimoni dari pengguna NusaBelajar yang sudah mempelajari berbagai kelas di NusaBelajar</p>
                </div>
            </div>
        </div>
        <div class="row testimonial-slider">
            @forelse ($testimonials as $testimonial)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-testimonial">
                        <div class="text">
                            <p>"{{ $testimonial->testimonial }}"</p>
                        </div>
                        <div class="author">
                            <h4 class="name">
                                {{ $testimonial->name }}
                                <span class="deg">{{ $testimonial->email }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-testimonial">
                        <div class="text">
                            <p>Tidak Ada Testimoni</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<section class="newsletter-area section">
    <div class="container">
        <div class="row ">
            <div class="col-lg-6 offset-lg-3 col-md-12 col-12">
                <div class="newsletter-title">
                    <span>Daftarkan Email Anda</span>
                    <h2>Berlangganan di NusaBelajar</h2>
                    <p>Segera daftarkan email anda untuk dapat berlangganan di NusaBelajar<br>Dengan berlangganan, anda akan selalu mendapatkan promo dan penawaran terbaru dari kami</p>
                </div>
                <div class="subscribe-text wow fadeInUp" data-wow-delay=".2s">
                    <form action="{{ route('email.subscription.store') }}" method="POST" class="newsletter-inner" enctype="multipart/form-data">
                    @csrf
                        <input type="text" name="email" placeholder="Masukkan Email Anda" class=" form-control common-input @error('email') is-invalid @enderror" value="{{ old('email') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukkan Email Anda'" autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="button">
                            <button type="submit" class="btn">Berlangganan</button>
                        </div>
                    </form>
                    <ul class="newsletter-social">
                        <li><a href="https://facebook.com/institutteknologidel" target="_blank"><i class="lni lni-facebook-original"></i></a></li>
                        <li><a href="https://twitter.com/institut_del" target="_blank"><i class="lni lni-twitter-original"></i></a></li>
                        <li><a href="https://instagram.com/it.del" target="_blank"><i class="lni lni-instagram"></i></a></li>
                        <li><a href="https://linkedin.com/school/institut-teknologi-del" target="_blank"><i class="lni lni-linkedin-original"></i></a></li>
                        <li><a href="https://youtube.com/channel/UC_X-wXdXDmZ2AyUD5zlS17g" target="_blank"><i class="lni lni-youtube"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="call-action section overlay">
    <div class="container">
        <div class="row ">
            <div class="col-lg-8 offset-lg-2 col-md-12 col-12">
                <div class="call-content">
                    <span>Persiapkan Masa Depan Yang Gemilang</span>
                    <h2>Capai Versi Terbaik Diri Anda</h2>
                    <p>Belajarlah selagi anda masih bisa untuk belajar. Karena dengan belajar kita bisa menjadi pribadi yang lebih baik dan bermanfaat bagi sesama</p>
                    <div class="button">
                        <a href="{{ route('course.index') }}" class="btn">Mulai Belajar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="latest-news-area style2 section">
    <div class="container">
        <div class="row">
        <div class="col-12">
            <div class="section-title">
                <span class="wow zoomIn" data-wow-delay="0.2s">Blog</span>
                <h2 class="wow fadeInUp" data-wow-delay=".4s">Blog Terpopuler</h2>
                <p class="wow fadeInUp" data-wow-delay=".6s">Ada banyak artikel berkualitas yang tersedia di blog NusaBelajar<br>Berikut beberapa artikel yang paling sering dilihat oleh pengunjung website NusaBelajar</p>
            </div>
        </div>
        </div>
        <div class="single-head">
            <div class="row">
                <div class="col-lg-3 col-md-12 col-12">
                    @forelse ($popular_articles_left as $popular_article_left)
                        <div class="single-news wow fadeInUp" data-wow-delay=".2s">
                            <div class="image">
                                <a href="{{ route('article.show', $popular_article_left->slug) }}">
                                    <img class="thumb" src="{{ Storage::url($popular_article_left->thumbnail) }}" alt="Thumbnail">
                                </a>
                            </div>
                            <div class="content-body">
                                <div class="meta-data">
                                    <ul>
                                        <li>
                                            <i class="lni lni-tag"></i>
                                            <a href="{{ route('article.category', $popular_article_left->article_category->slug) }}">{{ $popular_article_left->article_category->name }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <h4 class="title">
                                    <a href="{{ route('article.show', $popular_article_left->slug) }}">{{ $popular_article_left->title }}</a>
                                </h4>
                            </div>
                        </div>
                    @empty
                        <div class="single-news wow fadeInUp" data-wow-delay=".2s">
                            <div class="content-body">
                                <h4 class="title text-center">
                                    <a href="#">Tidak Ada Artikel</a>
                                </h4>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    @forelse ($popular_articles_center as $popular_article_center)
                        <div class="single-news big custom-shadow-hover wow fadeInUp" data-wow-delay=".4s">
                            <div class="image">
                                <a href="{{ route('article.show', $popular_article_center->slug) }}">
                                    <img class="thumb" src="{{ Storage::url($popular_article_center->thumbnail) }}" alt="Thumbnail">
                                </a>
                            </div>
                            <div class="content-body">
                                <div class="meta-data">
                                    <ul>
                                        <li>
                                            <i class="lni lni-tag"></i>
                                            <a href="{{ route('article.category', $popular_article_center->article_category->slug) }}">{{ $popular_article_center->article_category->name }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <h4 class="title">
                                    <a href="{{ route('article.show', $popular_article_center->slug) }}">{{ $popular_article_center->title }}</a>
                                </h4>
                                <p>{!! Str::words($popular_article_center->content, 20, '.....') !!}</p>
                                <div class="button">
                                    <a href="{{ route('article.show', $popular_article_center->slug) }}" class="btn">Lanjutkan Membaca</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="single-news big custom-shadow-hover wow fadeInUp" data-wow-delay=".4s">
                            <div class="content-body">
                                <h4 class="title text-center">
                                    <a href="#">Tidak Ada Artikel</a>
                                </h4>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="col-lg-3 col-md-12 col-12">
                    @forelse ($popular_articles_right as $popular_article_right)
                        <div class="single-news wow fadeInUp" data-wow-delay=".2s">
                            <div class="image">
                                <a href="{{ route('article.show', $popular_article_right->slug) }}">
                                    <img class="thumb" src="{{ Storage::url($popular_article_right->thumbnail) }}" alt="Thumbnail">
                                </a>
                            </div>
                            <div class="content-body">
                                <div class="meta-data">
                                    <ul>
                                        <li>
                                            <i class="lni lni-tag"></i>
                                            <a href="{{ route('article.category', $popular_article_right->article_category->slug) }}">{{ $popular_article_right->article_category->name }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <h4 class="title">
                                    <a href="{{ route('article.show', $popular_article_right->slug) }}">{{ $popular_article_right->title }}</a>
                                </h4>
                            </div>
                        </div>
                    @empty
                        <div class="single-news wow fadeInUp" data-wow-delay=".2s">
                            <div class="content-body">
                                <h4 class="title text-center">
                                    <a href="#">Tidak Ada Artikel</a>
                                </h4>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<section class="call-action style2 section overlay">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-8 col-12">
                <div class="call-content">
                    <h2>Siap untuk belajar? <br>Pilih kelas favorit anda sekarang.</h2>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-12">
                <div class="call-content">
                    <div class="button">
                        <a href="{{ route('course.index') }}" class="btn">Lihat Kelas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="client-logo-section">
    <div class="container">
        <div class="client-logo-wrapper">
            <div class="client-logo-carousel d-flex align-items-center justify-content-between">
                <div class="client-logo">
                    <img src="{{ asset('assets/homepage/images/clients/client1.svg') }}" alt="">
                </div>
                <div class="client-logo">
                    <img src="{{ asset('assets/homepage/images/clients/client2.svg') }}" alt="">
                </div>
                <div class="client-logo">
                    <img src="{{ asset('assets/homepage/images/clients/client3.svg') }}" alt="">
                </div>
                <div class="client-logo">
                    <img src="{{ asset('assets/homepage/images/clients/client4.svg') }}" alt="">
                </div>
                <div class="client-logo">
                    <img src="{{ asset('assets/homepage/images/clients/client5.svg') }}" alt="">
                </div>
                <div class="client-logo">
                    <img src="{{ asset('assets/homepage/images/clients/client2.svg') }}" alt="">
                </div>
                <div class="client-logo">
                    <img src="{{ asset('assets/homepage/images/clients/client3.svg') }}" alt="">
                </div>
                <div class="client-logo">
                    <img src="{{ asset('assets/homepage/images/clients/client4.svg') }}" alt="">
                </div>
                <div class="client-logo">
                    <img src="{{ asset('assets/homepage/images/clients/client5.svg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('addon-script')
<script type="text/javascript">
    tns({
        container: '.hero-slider',
        items: 1,
        slideBy: 'page',
        autoplay: false,
        mouseDrag: true,
        gutter: 0,
        nav: true,
        controls: false,
        controlsText: ['<i class="lni lni-arrow-left"></i>', '<i class="lni lni-arrow-right"></i>'],
    });
    tns({
        container: '.testimonial-slider',
        items: 3,
        slideBy: 'page',
        autoplay: false,
        mouseDrag: true,
        gutter: 0,
        nav: true,
        controls: false,
        controlsText: ['<i class="lni lni-arrow-left"></i>', '<i class="lni lni-arrow-right"></i>'],
        responsive: {
            0: {
                items: 1,
            },
            540: {
                items: 1,
            },
            768: {
                items: 2,
            },
            992: {
                items: 2,
            },
            1170: {
                items: 3,
            }
        }
    });
    tns({
        container: '.client-logo-carousel',
        slideBy: 'page',
        autoplay: true,
        autoplayButtonOutput: false,
        mouseDrag: true,
        gutter: 15,
        nav: false,
        controls: false,
        responsive: {
            0: {
                items: 1,
            },
            540: {
                items: 3,
            },
            768: {
                items: 4,
            },
            992: {
                items: 4,
            },
            1170: {
                items: 6,
            }
        }
    });
    GLightbox({
        'href': 'https://youtu.be/oW9s-3k-PGU',
        'type': 'video',
        'source': 'youtube',
        'width': 900,
        'autoplayVideos': true,
    });
</script>
@endpush