<!DOCTYPE html>
<html class="no-js" lang="id">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title>NusaBelajar - Selamat Datang</title>
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/homepage/images/favicon.svg') }}" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Spartan:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" />
        <link rel="stylesheet" href="{{ asset('assets/homepage/css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/homepage/css/LineIcons.2.0.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/homepage/css/animate.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/homepage/css/tiny-slider.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/homepage/css/glightbox.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/homepage/css/main.css') }}" />
    </head>
    <body>
        <div class="preloader">
            <div class="preloader-inner">
                <div class="preloader-icon">
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        <div class="mail-success">
            <div class="verticle-lines">
                <div class="vlines one"></div>
                <div class="vlines two"></div>
                <div class="vlines three"></div>
                <div class="vlines four"></div>
            </div>
            <div class="d-table">
                <div class="d-table-cell">
                    <div class="container">
                        <div class="mail-content">
                            <h1>Selamat Datang!</h1>
                            <h2>Email anda telah berhasil diverifikasi</h2>
                            <p>Terima kasih telah menjadi bagian dari NusaBelajar, mari bersama #MencerdaskanIndonesia</p>
                            <div class="button">
                                <a href="{{ route('homepage.index') }}" class="btn">Kembali Ke Beranda</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/homepage/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/homepage/js/count-up.min.js') }}"></script>
        <script src="{{ asset('assets/homepage/js/wow.min.js') }}"></script>
        <script src="{{ asset('assets/homepage/js/tiny-slider.js') }}"></script>
        <script src="{{ asset('assets/homepage/js/glightbox.min.js') }}"></script>
        <script>
            window.onload = function () {
                window.setTimeout(fadeout, 500);
            }
            function fadeout() {
                document.querySelector('.preloader').style.opacity = '0';
                document.querySelector('.preloader').style.display = 'none';
            }
        </script>
    </body>
</html>