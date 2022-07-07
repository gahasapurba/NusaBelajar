@extends('layouts.dashboard')
@section('title')
    Ubah Kelas - Mentor
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Ubah Kelas</h6>
                <form action="{{ route('dashboard.mentor.course.update', $hash->encodeHex($item->id)) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="select-style-1">
                                <label for="category_course_categories_id">Kategori Kelas</label>
                                <select name="category_course_categories_id" class="select2 form-control bg-transparent @error('category_course_categories_id') is-invalid @enderror" autofocus>
                                    <option value="">Pilih Kategori Kelas</option>
                                    @foreach ($course_categories as $course_category)
                                        <option value="{{ $hash->encodeHex($course_category->id) }}" @if($hash->encodeHex($item->category_course_categories_id) == $hash->encodeHex($course_category->id)) selected @endif>{{ $course_category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_course_categories_id')
                                    <small class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="title">Judul Kelas</label>
                                <input type="text" name="title" placeholder="Masukkan Judul Kelas" class="form-control bg-transparent @error('title') is-invalid @enderror" value="{{ $item->title }}"/>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="price">Harga Kelas (Rp)</label>
                                <input type="number" name="price" placeholder="Masukkan Harga Kelas" class="form-control bg-transparent @error('price') is-invalid @enderror" value="{{ $item->price }}"/>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="description">Deskripsi Kelas</label>
                                <textarea name="description" class="form-control bg-transparent @error('description') is-invalid @enderror" rows="10" placeholder="Masukkan Deskripsi Kelas"/>{{ $item->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="thumbnail">Thumbnail Kelas</label>
                                <input type="file" name="thumbnail" accept="image/*" onchange="loadFile(event)" placeholder="Unggah Thumbnail Kelas" class="form-control bg-transparent @error('thumbnail') is-invalid @enderror" value="{{ $item->thumbnail }}"/>
                                <small>Unggah Thumbnail Kelas</small>
                                <br>
                                <small>Harap Unggah Thumbnail Kelas Berukuran 1920 X 1020 (PX)</small>
                                @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                                <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ asset('assets/dashboard/images/courses/thumbnail.png') }}" alt="Thumbnail">
                                <br>
                                <img id="output" class="img-fluid rounded shadow mt-4" width="30%" src="{{ Storage::url($item->thumbnail) }}" alt="Thumbnail">
                            </div>
                            <div class="input-style-1">
                                <label for="introduction_youtube_video_link">Link Video YouTube Perkenalan Kelas</label>
                                <input type="text" name="introduction_youtube_video_link" placeholder="Masukkan Link Video YouTube Perkenalan Kelas" class="form-control bg-transparent @error('introduction_youtube_video_link') is-invalid @enderror" value="{{ $item->introduction_youtube_video_link }}"/>
                                @error('introduction_youtube_video_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="telegram_group_link">Link Grup Telegram Kelas</label>
                                <input type="text" name="telegram_group_link" placeholder="Masukkan Link Grup Telegram Kelas" class="form-control bg-transparent @error('telegram_group_link') is-invalid @enderror" value="{{ $item->telegram_group_link }}"/>
                                @error('telegram_group_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="syllabus">Silabus Kelas</label>
                                <input type="file" name="syllabus" placeholder="Unggah Silabus Kelas" class="form-control bg-transparent @error('syllabus') is-invalid @enderror" value="{{ $item->syllabus }}"/>
                                <small>Unggah Silabus Kelas</small>
                                <br>
                                <small>Silabus Kelas Tersimpan : <a href="{{ Storage::url($item->syllabus) }}" target="_blank">Unduh Silabus Kelas</a></small>
                                @error('syllabus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="file">File Kelas (Opsional)</label>
                                <input type="file" name="file" placeholder="Unggah File Kelas" class="form-control bg-transparent @error('file') is-invalid @enderror" value="{{ $item->file }}"/>
                                <small>Unggah File Kelas</small>
                                <br>
                                @if ($item->file)
                                    <small>File Kelas Tersimpan : <a href="{{ Storage::url($item->file) }}" target="_blank">Unduh File Kelas</a></small>
                                @else
                                    <small>Anda Belum Mengunggah File Kelas</small>
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
                                    Ubah Kelas
                                </button>
                                <a href="{{ route('dashboard.mentor.course.index') }}" class="main-btn danger-btn-outline m-2">
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