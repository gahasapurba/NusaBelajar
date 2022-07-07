@extends('layouts.dashboard')
@section('title')
    Buat Event - Mentor
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Buat Event</h6>
                <form action="{{ route('dashboard.mentor.event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="select-style-1">
                                <label for="category_event_categories_id">Kategori Event</label>
                                <select name="category_event_categories_id" class="select2 form-control bg-transparent @error('category_event_categories_id') is-invalid @enderror" autofocus>
                                    <option value="">Pilih Kategori Event</option>
                                    @foreach ($event_categories as $event_category)
                                        <option value="{{ $hash->encodeHex($event_category->id) }}" @if(old('category_event_categories_id') == $hash->encodeHex($event_category->id)) selected @endif>{{ $event_category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_event_categories_id')
                                    <small class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="title">Judul Event</label>
                                <input type="text" name="title" placeholder="Masukkan Judul Event" class="form-control bg-transparent @error('title') is-invalid @enderror" value="{{ old('title') }}"/>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="location">Lokasi Event</label>
                                <input type="text" name="location" placeholder="Masukkan Lokasi Event" class="form-control bg-transparent @error('location') is-invalid @enderror" value="{{ old('location') }}"/>
                                <small>Masukkan Alamat Lengkap Lokasi Penyelenggaraan Event, Apabila Event Dilaksanakan Secara Offline. Apabila Event Dilaksanakan Secara Online, Masukkan Link Zoom Meeting / Google Meet / Link Media Pertemuan Online Lainnya</small>
                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="google_map_link">Link Google Map Lokasi Event (Opsional)</label>
                                <input type="text" name="google_map_link" placeholder="Masukkan Link Google Map Lokasi Event" class="form-control bg-transparent @error('google_map_link') is-invalid @enderror" value="{{ old('google_map_link') }}"/>
                                <small>Masukkan Link Google Map Lokasi Event, Apabila Event Dilaksanakan Secara Offline</small>
                                @error('google_map_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="start_datetime">Waktu Event Dimulai</label>
                                <input type="datetime-local" name="start_datetime" placeholder="Masukkan Waktu Event Dimulai" class="form-control bg-transparent @error('start_datetime') is-invalid @enderror" value="{{ old('start_datetime') }}"/>
                                <small>Masukkan Waktu Event Dimulai</small>
                                @error('start_datetime')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="end_datetime">Waktu Event Berakhir</label>
                                <input type="datetime-local" name="end_datetime" placeholder="Masukkan Waktu Event Berakhir" class="form-control bg-transparent @error('end_datetime') is-invalid @enderror" value="{{ old('end_datetime') }}"/>
                                <small>Masukkan Waktu Event Berakhir</small>
                                @error('end_datetime')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="description">Deskripsi Event</label>
                                <textarea name="description" class="form-control bg-transparent @error('description') is-invalid @enderror" rows="10" placeholder="Masukkan Deskripsi Event"/>{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="thumbnail">Thumbnail Event</label>
                                <input type="file" name="thumbnail" accept="image/*" onchange="loadFile(event)" placeholder="Unggah Thumbnail Event" class="form-control bg-transparent @error('thumbnail') is-invalid @enderror" value="{{ old('thumbnail') }}"/>
                                <small>Unggah Thumbnail Event</small>
                                <br>
                                <small>Harap Unggah Thumbnail Event Berukuran 550 X 349 (PX)</small>
                                @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                                <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ asset('assets/dashboard/images/events/thumbnail.png') }}" alt="Thumbnail">
                                <br>
                                <img id="output" class="img-fluid rounded shadow mt-4" width="30%" src="{{ asset('assets/dashboard/images/events/uploaded-thumbnail.png') }}" alt="Thumbnail">
                            </div>
                            <div class="input-style-1">
                                <label for="file">File Event (Opsional)</label>
                                <input type="file" name="file" placeholder="Unggah File Event" class="form-control bg-transparent @error('file') is-invalid @enderror" value="{{ old('file') }}"/>
                                <small>Unggah File Event</small>
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
                                    Buat Event
                                </button>
                                <a href="{{ route('dashboard.mentor.event.index') }}" class="main-btn danger-btn-outline m-2">
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