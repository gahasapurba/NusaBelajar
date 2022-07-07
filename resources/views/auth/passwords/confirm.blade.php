@extends('layouts.homepage')
@section('title')
    Konfirmasi Password
@endsection
@section('content')
<section class="login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 col-12">
                <div class="form-head">
                    <h4 class="title">Konfirmasi Password</h4>
                    <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="margin-5px-bottom" type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password" placeholder="Masukkan Password Anda">
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
                                        <input type="checkbox" class="form-check-input width-auto" id="show_password" name="show_password" onclick="myFunction()">
                                        <label for="show_password" class="form-check-label">Tampilkan Password</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="lost-pass">Lupa password?</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="button">
                            <button type="submit" class="btn">Konfirmasi Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('addon-script')
<script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
@endpush