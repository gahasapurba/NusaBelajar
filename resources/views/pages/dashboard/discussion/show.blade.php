@extends('layouts.dashboard')
@section('title')
    Detail Diskusi
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Detail Diskusi</h6>
                <div class="row">
                    <div class="col-12">
                        <div class="input-style-1">
                            <label for="category_discussion_categories_id">Kategori Diskusi</label>
                            <input type="text" name="category_discussion_categories_id" class="bg-transparent" value="{{ $item->discussion_category->name }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="title">Judul Diskusi</label>
                            <input type="text" name="title" class="bg-transparent" value="{{ $item->title }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="description">Deskripsi Diskusi</label>
                            {!! $item->description !!}
                        </div>
                        @isset($item->file)
                            <div class="input-style-1">
                                <label for="file">File Diskusi (Opsional)</label>
                                <small><a href="{{ Storage::url($item->file) }}" target="_blank">Unduh File Diskusi</a></small>
                            </div>
                        @endisset
                        <div class="input-style-1">
                            <label for="status">Status Diskusi</label>
                            @if (!$item->is_accepted && !$item->is_rejected)
                                <span class="status-btn warning-btn">Proses Peninjauan</span>
                            @elseif ($item->is_accepted && !$item->is_rejected && $item->is_featured)
                                <span class="status-btn success-btn">Diskusi Disetujui</span>&nbsp;&nbsp;<span class="status-btn secondary-btn">Diskusi Direkomendasikan</span>
                            @elseif ($item->is_accepted && !$item->is_rejected)
                                <span class="status-btn success-btn">Diskusi Disetujui</span>
                            @elseif (!$item->is_accepted && $item->is_rejected)
                                <span class="status-btn danger-btn">Diskusi Ditolak</span>
                            @else
                                <span class="status-btn primary-btn"></span>
                            @endif
                        </div>
                        @isset($item->review)
                            <div class="input-style-1">
                                <label for="review">Review Diskusi (Opsional)</label>
                                {!! $item->review !!}
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
                            <a href="{{ route('dashboard.discussion.index') }}" class="main-btn primary-btn-outline m-2">
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