<footer class="footer">
    <div class="footer-middle">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="f-about single-footer">
                        <div class="logo">
                            <a href="{{ route('homepage.index') }}"><img src="{{ asset('assets/homepage/images/logo/logo.svg') }}" alt="Logo"></a>
                        </div>
                        <p>NusaBelajar hadir sebagai platform pembelajaran online yang dapat diakses oleh setiap masyarakat Indonesia tanpa batasan ruang dan waktu demi #MencerdaskanIndonesia</p>
                        <div class="footer-social">
                            <ul>
                                <li>
                                    <a href="https://facebook.com/institutteknologidel">
                                        <i class="lni lni-facebook-original"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/institut_del">
                                        <i class="lni lni-twitter-original"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://instagram.com/it.del">
                                        <i class="lni lni-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://youtube.com/channel/UC_X-wXdXDmZ2AyUD5zlS17g">
                                        <i class="lni lni-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-footer sm-custom-border recent-blog">
                        <h3>Artikel Terbaru</h3>
                        @php
                            $articles = App\Models\Article::where('is_accepted', true)->latest()->limit(3)->get();
                        @endphp
                        <ul>
                            @forelse ($articles as $article)
                                <li>
                                    <a href="{{ route('article.show', $article->slug) }}">
                                        <img src="{{ Storage::url($article->thumbnail) }}" alt="Article Thumbnail">{{ $article->title }}
                                    </a>
                                    <span class="date"><i class="lni lni-calendar"></i>{{ $article->created_at->isoFormat('D MMMM Y') }}</span>
                                </li>
                            @empty
                                <li>
                                    <a href="#">
                                        Tidak Ada Artikel
                                    </a>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-footer sm-custom-border f-link">
                        <h3>Halaman Terkait</h3>
                        <ul>
                            <li>
                                <a href="{{ route('mentor.verification.index') }}">Daftar Mentor</a>
                            </li>
                            <li>
                                <a href="#">Cek Sertifikat</a>
                            </li>
                            <li>
                                <a href="{{ route('aboutus.index') }}">Tentang Kami</a>
                            </li>
                            <li>
                                <a href="{{ route('contact.create') }}">Hubungi Kami</a>
                            </li>
                            <li>
                                <a href="{{ route('questionnaire.create') }}">Isi Kuesioner</a>
                            </li>
                            <li>
                                <a href="https://gahasapurba.com/apk/nusabelajar.apk" target="_blank">Unduh Aplikasi Untuk Android</a>
                            </li>
                            <li>
                                <a href="https://bit.ly/3K2ZA6b" target="_blank">Kebijakan Privasi</a>
                            </li>
                            <li>
                                <a href="https://bit.ly/3K3TEcO" target="_blank">Syarat & Ketentuan</a>
                            </li>
                            <li>
                                <a href="{{ route('faq.index') }}">FAQ</a>
                            </li>
                            <li>
                                <a href="https://youtube.com/playlist?list=PLXGJqtP3eZ42w_bUf3-ZxcTPVas7ph6xK" target="_blank">Bantuan / Tutorial</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="single-footer footer-newsletter">
                        <h3>Berlangganan Bersama Kami</h3>
                        <p>Berlangganan bersama kami untuk dapat tetap menerima informasi, serta berbagai layanan, promo, dan penawaran terbaru dari kami.</p>
                        <form action="{{ route('email.subscription.store') }}" method="POST" class="newsletter-form" enctype="multipart/form-data">
                        @csrf
                            <input type="text" name="email" placeholder="Masukkan Email Anda" class="form-control common-input @error('email') is-invalid @enderror" value="{{ old('email') }}" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Masukkan Email Anda'" autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="button">
                                <button type="submit" class="btn">Berlangganan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-12">
                        <div class="left">
                            <p>Didesain dan Dibangun Oleh<a href="{{ route('aboutus.index') }}">PA III - 07 - IT Del</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<a href="#" class="scroll-top btn-hover">
    <i class="lni lni-chevron-up"></i>
</a>