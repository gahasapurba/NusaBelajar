@extends('layouts.homepage')
@section('title')
    Hubungi Kami
@endsection
@section('content')
<section id="contact-us" class="contact-us section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12">
                <div class="form-main">
                    <h3 class="title">
                        <span>Silahkan kirimkan pertanyaan, saran, ataupun kritik anda melalui formulir berikut</span>
                        Hubungi Kami
                    </h3>
                    <div class="alert alert-success alert-dismissible fade show d-none my-alert" role="alert">
                        <strong>Terima kasih!</strong> Pesan anda sudah kami terima dan akan kami respon secepatnya
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <form class="form" name="submit-to-google-sheet">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="name">Nama Anda</label>
                                    <input name="name" type="text" placeholder="Masukkan Nama Anda" required autofocus>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="subject">Subjek Pesan</label>
                                    <input name="subject" type="text" placeholder="Masukkan Subjek Pesan" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email Anda</label>
                                    <input name="email" type="email" placeholder="Masukkan Email Anda" required>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="phone">No. HP (WhatsApp)</label>
                                    <input name="phone" type="number" placeholder="Masukkan No. HP (WhatsApp)" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group message">
                                    <label for="message">Isi Pesan</label>
                                    <textarea name="message" placeholder="Masukkan Isi Pesan" required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group button">
                                    <button type="submit" class="btn btn-kirim">Kirim Pesan</button>
                                    <button type="button" class="btn btn-primary btn-loading d-none" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Mohon Tunggu...
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="contact-info">
                    <div class="single-info">
                        <i class="lni lni-map-marker"></i>
                        <h4>Temui Kami</h4>
                        <p class="no-margin-bottom">Institut Teknologi Del, Jl. Sisingamangaraja, Desa Sitoluama, Kec. Laguboti, Kab. Toba, Sumatera Utara, Indonesia, 22381.</p>
                    </div>
                    <div class="single-info">
                        <i class="lni lni-phone"></i>
                        <h4>Telepon Kami</h4>
                        <p class="no-margin-bottom">No. HP : (+62) 811 6120 030
                        <br> WA : (+62) 811 6120 030</p>
                    </div>
                    <div class="single-info">
                        <i class="lni lni-envelope"></i>
                        <h4>Email Kami</h4>
                        <p class="no-margin-bottom">
                            <a href="mailto:nusabelajar@gmail.com">
                                <span class="__cf_email__">nusabelajar@gmail.com</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="map-section">
    <div class="mapouter">
        <div class="gmap_canvas">
            <iframe width="100%" height="500" id="gmap_canvas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.3673302250677!2d99.14644411531029!3d2.3832205580465007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e00fdad2d7341%3A0xf59ef99c591fe451!2sDel%20Institute%20of%20Technology!5e0!3m2!1sen!2sid!4v1654077742372!5m2!1sen!2sid" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
        </div>
    </div>
</div>
@endsection
@push('addon-script')
<script>
    const scriptURL = 'https://script.google.com/macros/s/AKfycbwY6th-Q9Jhr7-nyXfQV_hRlnoWKLU2rj9BwND4p3zqETYjp32RYC6HYQWe3dHIzPVX6g/exec'
    const form = document.forms['submit-to-google-sheet']
    const btnKirim = document.querySelector('.btn-kirim')
    const btnLoading = document.querySelector('.btn-loading')
    const myAlert = document.querySelector('.my-alert')

    form.addEventListener('submit', e => {
        e.preventDefault()
        // Ketika tombol kirim diklik, tampilkan tombol loading, hilangkan tombol kirim
        btnLoading.classList.toggle('d-none');
        btnKirim.classList.toggle('d-none');
        fetch(scriptURL, { method: 'POST', body: new FormData(form)})
            .then(response => {
                // Ketika berhasil dikirim, tampilkan tombol kirim, hilangkan tombol loading
                btnLoading.classList.toggle('d-none');
                btnKirim.classList.toggle('d-none');
                // Tampilkan alert berhasil
                myAlert.classList.toggle('d-none');
                // Reset formnya
                form.reset();
                console.log('Success!', response)
                @php
                    $administrators = App\Models\User::where('is_admin', true)->get();

                    foreach ($administrators as $administrator) {
                        App\Models\Notification::create([
                            'receiver_users_id' => $administrator->id,
                            'type' => 'admin.contact.show',
                            'title' => 'Pesan Form Contact Baru',
                            'subtitle' => 'perlu dilihat',
                            'content' => 'Pesan baru telah dikirim oleh seseorang melalui form contact di website NusaBelajar',
                        ]);
                        Mail::to($administrator->email)->send(new App\Mail\Admin\Contact);
                    }
                @endphp
            })
            .catch(error => console.error('Error!', error.message))
    })
</script>
@endpush