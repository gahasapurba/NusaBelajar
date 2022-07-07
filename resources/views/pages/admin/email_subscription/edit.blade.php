@extends('layouts.admin')
@section('title')
    Ubah Email Berlangganan
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Ubah Email Berlangganan</h6>
                <form action="{{ route('admin.email.subscription.update', $hash->encodeHex($item->id)) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="email">Email Berlangganan</label>
                                <input type="text" name="email" placeholder="Masukkan Email Berlangganan" class="form-control bg-transparent @error('email') is-invalid @enderror" value="{{ $item->email }}" autofocus/>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="button-group d-flex justify-content-center flex-wrap">
                                <button type="submit" class="main-btn primary-btn btn-hover m-2">
                                    Ubah Email Berlangganan
                                </button>
                                <a href="{{ route('admin.email.subscription.index') }}" class="main-btn danger-btn-outline m-2">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection