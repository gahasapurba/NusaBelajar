@extends('layouts.dashboard')
@section('title')
    Detail Artikel
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Detail Artikel</h6>
                <div class="row">
                    <div class="col-12">
                        <div class="input-style-1">
                            <label for="category_article_categories_id">Kategori Artikel</label>
                            <input type="text" name="category_article_categories_id" class="bg-transparent" value="{{ $item->article_category->name }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="tag_article_tags_id">Tag Artikel</label>
                            @foreach ($item->article_tags as $article_tag)
                                <span class="status-btn primary-btn">{{ $article_tag->name }}</span>
                            @endforeach
                        </div>
                        <div class="input-style-1">
                            <label for="title">Judul Artikel</label>
                            <input type="text" name="title" class="bg-transparent" value="{{ $item->title }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="content">Isi Artikel</label>
                            {!! $item->content !!}
                        </div>
                        <div class="input-style-1">
                            <label for="thumbnail">Thumbnail Artikel</label>
                            <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ Storage::url($item->thumbnail) }}" alt="Thumbnail">
                        </div>
                        @isset($item->file)
                            <div class="input-style-1">
                                <label for="file">File Artikel (Opsional)</label>
                                <small><a href="{{ Storage::url($item->file) }}" target="_blank">Unduh File Artikel</a></small>
                            </div>
                        @endisset
                        @isset($item->quote)
                            <div class="input-style-1">
                                <label for="quote">Kutipan Artikel (Opsional)</label>
                                <input type="text" name="quote" class="bg-transparent" value="{{ $item->quote }}" readonly/>
                            </div>
                        @endisset
                        <div class="input-style-1">
                            <label for="status">Status Artikel</label>
                            @if (!$item->is_accepted && !$item->is_rejected)
                                <span class="status-btn warning-btn">Proses Peninjauan</span>
                            @elseif ($item->is_accepted && !$item->is_rejected && $item->is_featured)
                                <span class="status-btn success-btn">Artikel Disetujui</span>&nbsp;&nbsp;<span class="status-btn secondary-btn">Artikel Direkomendasikan</span>
                            @elseif ($item->is_accepted && !$item->is_rejected)
                                <span class="status-btn success-btn">Artikel Disetujui</span>
                            @elseif (!$item->is_accepted && $item->is_rejected)
                                <span class="status-btn danger-btn">Artikel Ditolak</span>
                            @else
                                <span class="status-btn primary-btn"></span>
                            @endif
                        </div>
                        @isset($item->review)
                            <div class="input-style-1">
                                <label for="review">Review Artikel</label>
                                {!! $item->review !!}
                            </div>
                        @endisset
                        @if($item->is_accepted)
                            <div class="input-style-1">
                                <label for="view">Jumlah Pembacaan Artikel</label>
                                <input type="number" name="view" class="bg-transparent" value="{{ $item->view }}" readonly/>
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
                            <a href="{{ route('dashboard.article.index') }}" class="main-btn primary-btn-outline m-2">
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