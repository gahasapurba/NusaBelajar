@extends('layouts.dashboard')
@section('title')
    Detail Event - Mentor
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Detail Event</h6>
                <div class="row">
                    <div class="col-12">
                        <div class="input-style-1">
                            <label for="category_event_categories_id">Kategori Event</label>
                            <input type="text" name="category_event_categories_id" class="bg-transparent" value="{{ $item->event_category->name }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="title">Judul Event</label>
                            <input type="text" name="title" class="bg-transparent" value="{{ $item->title }}" readonly/>
                        </div>
                        @if(Str::startsWith($item->location, 'https://'))
                            <div class="input-style-1">
                                <label for="location">Lokasi Event</label>
                                <small><a href="{{ $item->location }}" target="_blank">{{ $item->location }}</a></small>
                            </div>
                        @else
                            <div class="input-style-1">
                                <label for="location">Lokasi Event</label>
                                <input type="text" name="location" class="bg-transparent" value="{{ $item->location }}" readonly/>
                            </div>
                        @endif
                        @isset($item->google_map_link)
                            <div class="input-style-1">
                                <label for="google_map_link">Link Google Map Lokasi Event (Opsional)</label>
                                <small><a href="{{ $item->google_map_link }}" target="_blank">Link</a></small>
                                <br>
                                <iframe src="{{ $item->google_map_link }}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        @endisset
                        <div class="input-style-1">
                            <label for="start_datetime">Waktu Event Dimulai</label>
                            <input type="text" name="start_datetime" class="bg-transparent" value="{{ $item->start_datetime->isoFormat('dddd, D MMMM Y, HH:mm:ss') }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="end_datetime">Waktu Event Berakhir</label>
                            <input type="text" name="end_datetime" class="bg-transparent" value="{{ $item->end_datetime->isoFormat('dddd, D MMMM Y, HH:mm:ss') }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="description">Deskripsi Event</label>
                            {!! $item->description !!}
                        </div>
                        <div class="input-style-1">
                            <label for="thumbnail">Thumbnail Event</label>
                            <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ Storage::url($item->thumbnail) }}" alt="Thumbnail">
                        </div>
                        @isset($item->file)
                            <div class="input-style-1">
                                <label for="file">File Event (Opsional)</label>
                                <small><a href="{{ Storage::url($item->file) }}" target="_blank">Unduh File Event</a></small>
                            </div>
                        @endisset
                        <div class="input-style-1">
                            <label for="status">Status Event</label>
                            @if (!$item->is_accepted && !$item->is_rejected)
                                <span class="status-btn warning-btn">Proses Peninjauan</span>
                            @elseif ($item->is_accepted && !$item->is_rejected)
                                <span class="status-btn success-btn">Event Disetujui</span>
                            @elseif (!$item->is_accepted && $item->is_rejected)
                                <span class="status-btn danger-btn">Event Ditolak</span>
                            @else
                                <span class="status-btn primary-btn"></span>
                            @endif
                        </div>
                        @isset($item->review)
                            <div class="input-style-1">
                                <label for="review">Review Event</label>
                                {!! $item->review !!}
                            </div>
                        @endisset
                        @if($item->is_accepted)
                            <div class="input-style-1">
                                <label for="registered_people">Jumlah Orang Yang Telah Mendaftar Di Event</label>
                                <input type="number" name="registered_people" class="bg-transparent" value="{{ $item->registered_people }}" readonly/>
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
                            <a href="{{ route('dashboard.mentor.event.index') }}" class="main-btn primary-btn-outline m-2">
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