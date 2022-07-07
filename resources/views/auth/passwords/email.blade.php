@extends('layouts.homepage')
@section('title')
    Reset Password (Konfirmasi Email)
@endsection
@section('content')
<section class="login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                <div class="form-head">
                    <h4 class="title">Reset Password (Konfirmasi Email)</h4>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="margin-5px-bottom" type="text" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Masukkan Email Anda">
                            <small>Masukkan email yang telah terdaftar sebelumnya. Tautan reset password akan dikirim ke email yang anda masukkan</small>
                            @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="button">
                            <button type="submit" class="btn">Kirim Tautan Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection