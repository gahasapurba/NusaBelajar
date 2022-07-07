@extends('layouts.dashboard')
@section('title')
    Detail Verifikasi Mentor
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Detail Verifikasi Mentor</h6>
                <div class="row">
                    <div class="col-12">
                        <div class="input-style-1">
                            <label for="profile_summary">Deskripsi Diri</label>
                            {!! $item->profile_summary !!}
                        </div>
                        <div class="input-style-1">
                            <label for="id_card">Foto KTP</label>
                            <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ Storage::url($item->id_card) }}" alt="ID Card">
                        </div>
                        <div class="input-style-1">
                            <label for="selfie_with_id_card">Foto Selfie Dengan KTP</label>
                            <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ Storage::url($item->selfie_with_id_card) }}" alt="ID Card">
                        </div>
                        <div class="input-style-1">
                            <label for="resume">Resume</label>
                            <small><a href="{{ Storage::url($item->resume) }}" target="_blank">Unduh Resume</a></small>
                        </div>
                        <div class="input-style-1">
                            <label for="whatsapp_number">No. HP (WhatsApp)</label>
                            <input type="number" name="whatsapp_number" class="bg-transparent" value="{{ $item->whatsapp_number }}" readonly/>
                        </div>
                        @isset($item->facebook_profile_link)
                            <div class="input-style-1">
                                <label for="facebook_profile_link">Link Profil Facebook (Opsional)</label>
                                <small><a href="{{ $item->facebook_profile_link }}" target="_blank">{{ $item->facebook_profile_link }}</a></small>
                            </div>
                        @endisset
                        @isset($item->instagram_profile_link)
                            <div class="input-style-1">
                                <label for="instagram_profile_link">Link Profil Instagram (Opsional)</label>
                                <small><a href="{{ $item->instagram_profile_link }}" target="_blank">{{ $item->instagram_profile_link }}</a></small>
                            </div>
                        @endisset
                        @isset($item->linkedin_profile_link)
                            <div class="input-style-1">
                                <label for="linkedin_profile_link">Link Profil LinkedIn (Opsional)</label>
                                <small><a href="{{ $item->linkedin_profile_link }}" target="_blank">{{ $item->linkedin_profile_link }}</a></small>
                            </div>
                        @endisset
                        <div class="input-style-1">
                            <label for="bank_account_number">No. Rekening Bank</label>
                            <input type="number" name="bank_account_number" class="bg-transparent" value="{{ $item->bank_account_number }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="bank_account_name">Nama Pemilik Rekening Bank</label>
                            <input type="text" name="bank_account_name" class="bg-transparent" value="{{ $item->bank_account_name }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="bank_name">Nama Bank</label>
                            <input type="text" name="bank_name" class="bg-transparent" value="{{ $item->bank_name }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="status">Status Verifikasi Mentor</label>
                            @if (!$item->is_accepted && !$item->is_rejected)
                                <span class="status-btn warning-btn">Proses Peninjauan</span>
                            @elseif ($item->is_accepted && !$item->is_rejected)
                                <span class="status-btn success-btn">Verifikasi Mentor Disetujui</span>
                            @elseif (!$item->is_accepted && $item->is_rejected)
                                <span class="status-btn danger-btn">Verifikasi Mentor Ditolak</span>
                            @else
                                <span class="status-btn primary-btn"></span>
                            @endif
                        </div>
                        @isset($item->review)
                            <div class="input-style-1">
                                <label for="review">Review Verifikasi Mentor</label>
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
                            <a href="{{ route('dashboard.mentor.verification.index') }}" class="main-btn primary-btn-outline m-2">
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