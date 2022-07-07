@extends('layouts.homepage')
@section('title')
    Isi Kuesioner
@endsection
@section('content')
<section id="contact-us" class="contact-us section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-12">
                <div class="form-main">
                    <h3 class="title">
                        <span>Silahkan berikan penilaian anda melalui kuesioner berikut</span>
                        Isi Kuesioner
                    </h3>
                    <form action="{{ route('questionnaire.store') }}" method="POST" class="form" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="name">Nama Anda</label>
                                    <input name="name" type="text" placeholder="Masukkan Nama Anda" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus>
                                    @error('name')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="email">Email Anda</label>
                                    <input name="email" type="text" placeholder="Masukkan Email Anda" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="answer1">Menurut Anda, Apakah Website Ini Bermanfaat ?</label>
                                    <select name="answer1" class="select2 form-control @error('answer1') is-invalid @enderror">
                                        <option value="">Pilih Jawaban</option>
                                        <option value="Tidak Bermanfaat" @if(old('answer1') == 'Tidak Bermanfaat') selected @endif>Tidak Bermanfaat</option>
                                        <option value="Kurang Bermanfaat" @if(old('answer1') == 'Kurang Bermanfaat') selected @endif>Kurang Bermanfaat</option>
                                        <option value="Bermanfaat" @if(old('answer1') == 'Bermanfaat') selected @endif>Bermanfaat</option>
                                        <option value="Sangat Bermanfaat" @if(old('answer1') == 'Sangat Bermanfaat') selected @endif>Sangat Bermanfaat</option>
                                    </select>
                                    @error('answer1')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="answer2">Menurut Anda, Apakah Kelas Yang Ada Di Website Ini Sudah Lengkap ?</label>
                                    <select name="answer2" class="select2 form-control @error('answer2') is-invalid @enderror">
                                        <option value="">Pilih Jawaban</option>
                                        <option value="Tidak Lengkap" @if(old('answer2') == 'Tidak Lengkap') selected @endif>Tidak Lengkap</option>
                                        <option value="Kurang Lengkap" @if(old('answer2') == 'Kurang Lengkap') selected @endif>Kurang Lengkap</option>
                                        <option value="Lengkap" @if(old('answer2') == 'Lengkap') selected @endif>Lengkap</option>
                                        <option value="Sangat Lengkap" @if(old('answer2') == 'Sangat Lengkap') selected @endif>Sangat Lengkap</option>
                                    </select>
                                    @error('answer2')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="answer3">Menurut Anda, Apakah Blog & Forum Diskusi Yang Ada Di Website Ini Bermanfaat ?</label>
                                    <select name="answer3" class="select2 form-control @error('answer3') is-invalid @enderror">
                                        <option value="">Pilih Jawaban</option>
                                        <option value="Tidak Bermanfaat" @if(old('answer3') == 'Tidak Bermanfaat') selected @endif>Tidak Bermanfaat</option>
                                        <option value="Kurang Bermanfaat" @if(old('answer3') == 'Kurang Bermanfaat') selected @endif>Kurang Bermanfaat</option>
                                        <option value="Bermanfaat" @if(old('answer3') == 'Bermanfaat') selected @endif>Bermanfaat</option>
                                        <option value="Sangat Bermanfaat" @if(old('answer3') == 'Sangat Bermanfaat') selected @endif>Sangat Bermanfaat</option>
                                    </select>
                                    @error('answer3')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="form-group">
                                    <label for="answer4">Menurut Anda, Bagaimana Kualitas Event / Kegiatan Yang Ditawarkan Melalui Website Ini ?</label>
                                    <select name="answer4" class="select2 form-control @error('answer4') is-invalid @enderror">
                                        <option value="">Pilih Jawaban</option>
                                        <option value="Tidak Berkualitas" @if(old('answer4') == 'Tidak Berkualitas') selected @endif>Tidak Berkualitas</option>
                                        <option value="Kurang Berkualitas" @if(old('answer4') == 'Kurang Berkualitas') selected @endif>Kurang Berkualitas</option>
                                        <option value="Berkualitas" @if(old('answer4') == 'Berkualitas') selected @endif>Berkualitas</option>
                                        <option value="Sangat Berkualitas" @if(old('answer4') == 'Sangat Berkualitas') selected @endif>Sangat Berkualitas</option>
                                    </select>
                                    @error('answer4')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group message">
                                    <label for="testimonial">Saran / Masukan / Testimoni Anda</label>
                                    <textarea name="testimonial" placeholder="Masukkan Saran / Masukan / Testimoni Anda" class="form-control @error('testimonial') is-invalid @enderror">{{ old('testimonial') }}</textarea>
                                    @error('testimonial')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group button">
                                    <button type="submit" class="btn">Kirim Hasil Kuesioner</button>
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