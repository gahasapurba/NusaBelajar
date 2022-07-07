@extends('layouts.admin')
@section('title')
    Buat Sertifikat Kelas
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Buat Sertifikat Kelas</h6>
                <form action="{{ route('admin.course.certificate.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="receiver_users_id">Nama Penerima Sertifikat Kelas</label>
                                <select name="receiver_users_id" class="select2 form-control bg-transparent @error('receiver_users_id') is-invalid @enderror" autofocus>
                                    <option value="">Pilih Nama Penerima Sertifikat Kelas</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $hash->encodeHex($user->id) }}" @if(old('receiver_users_id') == $hash->encodeHex($user->id)) selected @endif>{{ $user->name }} - {{ $user->email }} (@if ($user->is_mentor) Mentor @else User @endif)</option>
                                    @endforeach
                                </select>
                                @error('receiver_users_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="course_courses_id">Judul Kelas Sertifikat Kelas</label>
                                <select name="course_courses_id" class="select2 form-control bg-transparent @error('course_courses_id') is-invalid @enderror">
                                    <option value="">Pilih Judul Kelas Sertifikat Kelas</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $hash->encodeHex($course->id) }}" @if(old('course_courses_id') == $hash->encodeHex($course->id)) selected @endif>{{ $course->title }}</option>
                                    @endforeach
                                </select>
                                @error('course_courses_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="button-group d-flex justify-content-center flex-wrap">
                                <button type="submit" class="main-btn primary-btn btn-hover m-2">
                                    Buat Sertifikat Kelas
                                </button>
                                <a href="{{ route('admin.course.certificate.index') }}" class="main-btn danger-btn-outline m-2">
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