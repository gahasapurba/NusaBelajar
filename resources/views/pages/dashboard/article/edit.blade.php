@extends('layouts.dashboard')
@section('title')
    Ubah Artikel
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Ubah Artikel</h6>
                <form action="{{ route('dashboard.article.update', $hash->encodeHex($item->id)) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="select-style-1">
                                <label for="category_article_categories_id">Kategori Artikel</label>
                                <select name="category_article_categories_id" class="select2 form-control bg-transparent @error('category_article_categories_id') is-invalid @enderror" autofocus>
                                    <option value="">Pilih Kategori Artikel</option>
                                    @foreach ($article_categories as $article_category)
                                        <option value="{{ $hash->encodeHex($article_category->id) }}" @if($hash->encodeHex($item->category_article_categories_id) == $hash->encodeHex($article_category->id)) selected @endif>{{ $article_category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_article_categories_id')
                                    <small class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="select-style-1">
                                <label for="tag_article_tags_id">Tag Artikel</label>
                                <select name="tag_article_tags_id[]" data-placeholder="Pilih Tag Artikel" class="select2 form-control bg-transparent @error('tag_article_tags_id') is-invalid @enderror" multiple>
                                    @foreach ($article_tags as $article_tag)
                                        <option value="{{ $article_tag->id }}" @foreach ($item->article_tags as $tag_article_tags_id) @if(collect($tag_article_tags_id)->contains($article_tag->id)) selected @endif @endforeach>{{ $article_tag->name }}</option>
                                    @endforeach
                                </select>
                                @error('tag_article_tags_id')
                                    <small class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="title">Judul Artikel</label>
                                <input type="text" name="title" placeholder="Masukkan Judul Artikel" class="form-control bg-transparent @error('title') is-invalid @enderror" value="{{ $item->title }}"/>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="content">Isi Artikel</label>
                                <textarea name="content" class="form-control bg-transparent @error('content') is-invalid @enderror" rows="10" placeholder="Masukkan Isi Artikel"/>{{ $item->content }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="thumbnail">Thumbnail Artikel</label>
                                <input type="file" name="thumbnail" accept="image/*" onchange="loadFile(event)" placeholder="Unggah Thumbnail Artikel" class="form-control bg-transparent @error('thumbnail') is-invalid @enderror" value="{{ $item->thumbnail }}"/>
                                <small>Unggah Thumbnail Artikel</small>
                                <br>
                                <small>Harap Unggah Thumbnail Artikel Berukuran 550 X 342 (PX)</small>
                                @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                                <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ asset('assets/dashboard/images/articles/thumbnail.png') }}" alt="Thumbnail">
                                <br>
                                <img id="output" class="img-fluid rounded shadow mt-4" width="30%" src="{{ Storage::url($item->thumbnail) }}" alt="Thumbnail">
                            </div>
                            <div class="input-style-1">
                                <label for="file">File Artikel (Opsional)</label>
                                <input type="file" name="file" placeholder="Unggah File Artikel" class="form-control bg-transparent @error('file') is-invalid @enderror" value="{{ $item->file }}"/>
                                <small>Unggah File Artikel</small>
                                <br>
                                @if ($item->file)
                                    <small>File Artikel Tersimpan : <a href="{{ Storage::url($item->file) }}" target="_blank">Unduh File Artikel</a></small>
                                @else
                                    <small>Anda Belum Mengunggah File Artikel</small>
                                @endif
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="quote">Kutipan Artikel (Opsional)</label>
                                <input type="text" name="quote" placeholder="Masukkan Kutipan Artikel" class="form-control bg-transparent @error('quote') is-invalid @enderror" value="{{ $item->quote }}"/>
                                @if (!$item->quote)
                                    <small>Anda Belum Memasukkan Kutipan Artikel</small>
                                @endif
                                @error('quote')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="button-group d-flex justify-content-center flex-wrap">
                                <button type="submit" class="main-btn primary-btn btn-hover m-2">
                                    Ubah Artikel
                                </button>
                                <a href="{{ route('dashboard.article.index') }}" class="main-btn danger-btn-outline m-2">
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
@push('addon-script')
<script>
    var loadFile = function(event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@endpush