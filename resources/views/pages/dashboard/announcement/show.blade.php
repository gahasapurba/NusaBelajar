@extends('layouts.dashboard')
@section('title')
    Detail Pengumuman
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Detail Pengumuman</h6>
                <div class="row">
                    <div class="col-12">
                        <div class="input-style-1">
                            <label for="title">Judul Pengumuman</label>
                            <input type="text" name="title" class="bg-transparent" value="{{ $item->title }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="content">Isi Pengumuman</label>
                            {!! $item->content !!}
                        </div>
                        @isset($item->file)
                            <div class="input-style-1">
                                <label for="file">File Pengumuman</label>
                                <small><a href="{{ Storage::url($item->file) }}" target="_blank">Unduh File Pengumuman</a></small>
                            </div>
                        @endisset
                        <div class="input-style-1">
                            <label for="created_at">Dibuat Pada</label>
                            <input type="text" name="created_at" class="bg-transparent" value="{{ $item->created_at->isoFormat('dddd, D MMMM Y, HH:mm:ss') }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="updated_at">Diubah Pada</label>
                            <input type="text" name="updated_at" class="bg-transparent" value="{{ $item->updated_at->isoFormat('dddd, D MMMM Y, HH:mm:ss') }}" readonly/>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="button-group d-flex justify-content-center flex-wrap">
                            <a href="{{ route('dashboard.announcement.index') }}" class="main-btn primary-btn-outline m-2">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection