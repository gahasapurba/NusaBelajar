@extends('layouts.admin')
@section('title')
    Buat Promo
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Buat Promo</h6>
                <form action="{{ route('admin.discount.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="name">Nama Promo</label>
                                <input type="text" name="name" placeholder="Masukkan Nama Promo" class="form-control bg-transparent @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus/>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="description">Deskripsi Promo</label>
                                <textarea name="description" class="form-control bg-transparent @error('description') is-invalid @enderror" rows="10" placeholder="Masukkan Deskripsi Promo"/>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="code">Kode Promo</label>
                                <input type="text" name="code" placeholder="Masukkan Kode Promo" class="form-control bg-transparent @error('code') is-invalid @enderror" value="{{ old('code') }}"/>
                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="percentage">Persenan Promo</label>
                                <input type="number" name="percentage" placeholder="Masukkan Persenan Promo" class="form-control bg-transparent @error('percentage') is-invalid @enderror" value="{{ old('percentage') }}"/>
                                @error('percentage')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="button-group d-flex justify-content-center flex-wrap">
                                <button type="submit" class="main-btn primary-btn btn-hover m-2">
                                    Buat Promo
                                </button>
                                <a href="{{ route('admin.discount.index') }}" class="main-btn danger-btn-outline m-2">
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