@extends('layouts.admin')
@section('title')
    Buat Kategori Artikel
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Buat Kategori Artikel</h6>
                <form action="{{ route('admin.article.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="name">Nama Kategori Artikel</label>
                                <input type="text" name="name" placeholder="Masukkan Nama Kategori Artikel" class="form-control bg-transparent @error('name') is-invalid @enderror" value="{{ old('name') }}" autofocus/>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="button-group d-flex justify-content-center flex-wrap">
                                <button type="submit" class="main-btn primary-btn btn-hover m-2">
                                    Buat Kategori Artikel
                                </button>
                                <a href="{{ route('admin.article.category.index') }}" class="main-btn danger-btn-outline m-2">
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