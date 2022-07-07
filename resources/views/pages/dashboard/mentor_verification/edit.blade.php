@extends('layouts.dashboard')
@section('title')
    Ubah Verifikasi Mentor
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Ubah Verifikasi Mentor</h6>
                <form action="{{ route('dashboard.mentor.verification.update', $hash->encodeHex($item->id)) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="profile_summary">Deskripsi Diri</label>
                                <textarea name="profile_summary" class="form-control bg-transparent @error('profile_summary') is-invalid @enderror" rows="10" placeholder="Masukkan Deskripsi Diri"/>{{ $item->profile_summary }}</textarea>
                                @error('profile_summary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="id_card">Foto KTP</label>
                                <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ Storage::url($item->id_card) }}" alt="ID Card">
                                <br>
                                <small>Foto KTP Tidak Dapat Diubah</small>
                            </div>
                            <div class="input-style-1">
                                <label for="selfie_with_id_card">Foto Selfie Dengan KTP</label>
                                <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ Storage::url($item->selfie_with_id_card) }}" alt="ID Card">
                                <br>
                                <small>Foto Selfie Dengan KTP Tidak Dapat Diubah</small>
                            </div>
                            <div class="input-style-1">
                                <label for="resume">Resume</label>
                                <small><a href="{{ Storage::url($item->resume) }}" target="_blank">Unduh Resume</a></small>
                                <br>
                                <small>Resume Tidak Dapat Diubah</small>
                            </div>
                            <div class="input-style-1">
                                <label for="whatsapp_number">No. HP (WhatsApp)</label>
                                <input type="number" name="whatsapp_number" placeholder="Masukkan No. HP (WhatsApp)" class="form-control bg-transparent @error('whatsapp_number') is-invalid @enderror" value="{{ $item->whatsapp_number }}"/>
                                @error('whatsapp_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="facebook_profile_link">Link Profil Facebook (Opsional)</label>
                                <input type="text" name="facebook_profile_link" placeholder="Masukkan Link Profil Facebook" class="form-control bg-transparent @error('facebook_profile_link') is-invalid @enderror" value="{{ $item->facebook_profile_link }}"/>
                                <small>Masukkan Link Profil Facebook</small>
                                @error('facebook_profile_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="instagram_profile_link">Link Profil Instagram (Opsional)</label>
                                <input type="text" name="instagram_profile_link" placeholder="Masukkan Link Profil Instagram" class="form-control bg-transparent @error('instagram_profile_link') is-invalid @enderror" value="{{ $item->instagram_profile_link }}"/>
                                <small>Masukkan Link Profil Instagram</small>
                                @error('instagram_profile_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="linkedin_profile_link">Link Profil LinkedIn (Opsional)</label>
                                <input type="text" name="linkedin_profile_link" placeholder="Masukkan Link Profil LinkedIn" class="form-control bg-transparent @error('linkedin_profile_link') is-invalid @enderror" value="{{ $item->linkedin_profile_link }}"/>
                                <small>Masukkan Link Profil LinkedIn</small>
                                @error('linkedin_profile_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="bank_account_number">No. Rekening Bank</label>
                                <input type="number" name="bank_account_number" placeholder="Masukkan No. Rekening Bank" class="form-control bg-transparent @error('bank_account_number') is-invalid @enderror" value="{{ $item->bank_account_number }}"/>
                                @error('bank_account_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="bank_account_name">Nama Pemilik Rekening Bank</label>
                                <input type="text" name="bank_account_name" placeholder="Masukkan Nama Pemilik Rekening Bank" class="form-control bg-transparent @error('bank_account_name') is-invalid @enderror" value="{{ $item->bank_account_name }}"/>
                                @error('bank_account_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="bank_name">Nama Bank</label>
                                <input type="text" name="bank_name" placeholder="Masukkan Nama Pemilik Rekening Bank" class="form-control bg-transparent @error('bank_name') is-invalid @enderror" value="{{ $item->bank_name }}"/>
                                @error('bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="button-group d-flex justify-content-center flex-wrap">
                                <button type="submit" class="main-btn primary-btn btn-hover m-2">
                                    Ubah Verifikasi Mentor
                                </button>
                                <a href="{{ route('dashboard.mentor.verification.index') }}" class="main-btn danger-btn-outline m-2">
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
    var loadFile2 = function(event) {
        var output = document.getElementById('output2');
        output.src = URL.createObjectURL(event.target.files[0]);
    };
</script>
@endpush