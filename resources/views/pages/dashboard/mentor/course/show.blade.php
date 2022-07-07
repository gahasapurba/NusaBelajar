@extends('layouts.dashboard')
@section('title')
    Detail Kelas - Mentor
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Detail Kelas</h6>
                <div class="row">
                    <div class="col-12">
                        <div class="input-style-1">
                            <label for="category_course_categories_id">Kategori Kelas</label>
                            <input type="text" name="category_course_categories_id" class="bg-transparent" value="{{ $item->course_category->name }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="title">Judul Kelas</label>
                            <input type="text" name="title" class="bg-transparent" value="{{ $item->title }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="price">Harga Kelas (Rp)</label>
                            <input type="text" name="price" class="bg-transparent" value="Rp{{ number_format($item->price, 2, ',', '.') }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="description">Deskripsi Kelas</label>
                            {!! $item->description !!}
                        </div>
                        <div class="input-style-1">
                            <label for="thumbnail">Thumbnail Kelas</label>
                            <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ Storage::url($item->thumbnail) }}" alt="Thumbnail">
                        </div>
                        <div class="input-style-1">
                            <label for="introduction_youtube_video_link">Link Video YouTube Perkenalan Kelas</label>
                            <small><a href="{{ $item->introduction_youtube_video_link }}" target="_blank">{{ $item->introduction_youtube_video_link }}</a></small>
                        </div>
                        <div class="input-style-1">
                            <label for="telegram_group_link">Link Grup Telegram Kelas</label>
                            <small><a href="{{ $item->telegram_group_link }}" target="_blank">{{ $item->telegram_group_link }}</a></small>
                        </div>
                        <div class="input-style-1">
                            <label for="syllabus">Silabus Kelas</label>
                            <small><a href="{{ Storage::url($item->syllabus) }}" target="_blank">Unduh Silabus Kelas</a></small>
                        </div>
                        @isset($item->file)
                            <div class="input-style-1">
                                <label for="file">File Kelas (Opsional)</label>
                                <small><a href="{{ Storage::url($item->file) }}" target="_blank">Unduh File Kelas</a></small>
                            </div>
                        @endisset
                        <div class="input-style-1">
                            <label for="status">Status Kelas</label>
                            @if (!$item->is_accepted && !$item->is_rejected)
                                <span class="status-btn warning-btn">Proses Peninjauan</span>
                            @elseif ($item->is_accepted && !$item->is_rejected && $item->is_featured)
                                <span class="status-btn success-btn">Kelas Disetujui</span>&nbsp;&nbsp;<span class="status-btn secondary-btn">Kelas Direkomendasikan</span>
                            @elseif ($item->is_accepted && !$item->is_rejected)
                                <span class="status-btn success-btn">Kelas Disetujui</span>
                            @elseif (!$item->is_accepted && $item->is_rejected)
                                <span class="status-btn danger-btn">Kelas Ditolak</span>
                            @else
                                <span class="status-btn primary-btn"></span>
                            @endif
                        </div>
                        @isset($item->review)
                            <div class="input-style-1">
                                <label for="review">Review Kelas</label>
                                {!! $item->review !!}
                            </div>
                        @endisset
                        @if($item->is_accepted)
                            <div class="input-style-1">
                                <label for="enrolled_people">Jumlah Orang Yang Telah Mendaftar Di Kelas</label>
                                <input type="number" name="enrolled_people" class="bg-transparent" value="{{ $item->enrolled_people }}" readonly/>
                            </div>
                        @endif
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
                            <a href="{{ route('dashboard.mentor.course.index') }}" class="main-btn primary-btn-outline m-2">
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