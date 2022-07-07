@extends('layouts.homepage')
@section('title')
    Registrasi
@endsection
@section('content')
<section class="login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                <div class="form-head">
                    <h4 class="title">Registrasi Akun</h4>
                    <form method="POST" action="{{ route('register') }}">
                    @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input class="margin-5px-bottom" type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Masukkan Nama Anda">
                            @error('name')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="margin-5px-bottom" type="text" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Masukkan Email Anda">
                            <small>Tautan verifikasi akan dikirim ke email yang anda masukkan</small>
                            @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="margin-5px-bottom" type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password" placeholder="Masukkan Password Anda">
                            @error('password')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="check-and-pass">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input width-auto" id="show_password" name="show_password" onclick="myFunction1()">
                                        <label for="show_password" class="form-check-label">Tampilkan Password</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <label for="password-confirm">Konfirmasi Password</label>
                            <input class="margin-5px-bottom" type="password" id="password-confirm" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="new-password" placeholder="Masukkan Ulang Password Anda">
                        </div>
                        <div class="check-and-pass">
                            <div class="row align-items-center">
                                <div class="col-lg-6 col-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input width-auto" id="show_password_confirmation" name="show_password_confirmation" onclick="myFunction2()">
                                        <label for="show_password_confirmation" class="form-check-label">Tampilkan Konfirmasi Password</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="button">
                            <button type="submit" class="btn">Daftar Akun</button>
                        </div>
                        <div class="button">
                            <a href="{{ route('user.google') }}" class="btn"><img src="https://freesvg.org/img/1534129544.png" alt="Google" style="width: 5%"> Daftar Dengan Akun Google</a>
                        </div>
                        <p class="outer-link">
                            Sudah punya akun? <a href="{{ route('login') }}">Silahkan masuk menggunakan akun anda</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('addon-script')
<script>
    function myFunction1() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function myFunction2() {
        var x = document.getElementById("password-confirm");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
@endpush