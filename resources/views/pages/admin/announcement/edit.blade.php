@extends('layouts.admin')
@section('title')
    Ubah Pengumuman
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Ubah Pengumuman</h6>
                <form action="{{ route('admin.announcement.update', $hash->encodeHex($item->id)) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="title">Judul Pengumuman</label>
                                <input type="text" name="title" placeholder="Masukkan Judul Pengumuman" class="form-control bg-transparent @error('title') is-invalid @enderror" value="{{ $item->title }}" autofocus/>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="content">Isi Pengumuman</label>
                                <textarea name="content" class="form-control bg-transparent @error('content') is-invalid @enderror" rows="10" placeholder="Masukkan Isi Pengumuman"/>{{ $item->content }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="file">File Pengumuman (Opsional)</label>
                                <input type="file" name="file" placeholder="Unggah File Pengumuman" class="form-control bg-transparent @error('file') is-invalid @enderror" value="{{ $item->file }}"/>
                                <small>Unggah File Pengumuman</small>
                                <br>
                                @if ($item->file)
                                    <small>File Pengumuman Tersimpan : <a href="{{ Storage::url($item->file) }}" target="_blank">Unduh File Pengumuman</a></small>
                                @else
                                    <small>Anda Belum Mengunggah File Pengumuman</small>
                                @endif
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="button-group d-flex justify-content-center flex-wrap">
                                <button type="submit" class="main-btn primary-btn btn-hover m-2">
                                    Ubah Pengumuman
                                </button>
                                <a href="{{ route('admin.announcement.index') }}" class="main-btn danger-btn-outline m-2">
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