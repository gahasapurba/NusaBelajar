@extends('layouts.dashboard')
@section('title')
    Buat Verifikasi Mentor
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Buat Verifikasi Mentor</h6>
                <form action="{{ route('dashboard.mentor.verification.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="profile_summary">Deskripsi Diri</label>
                                <textarea name="profile_summary" class="form-control bg-transparent @error('profile_summary') is-invalid @enderror" rows="10" placeholder="Masukkan Deskripsi Diri" autofocus/>{{ old('profile_summary') }}</textarea>
                                @error('profile_summary')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="id_card">Foto KTP</label>
                                <input type="file" name="id_card" accept="image/*" onchange="loadFile(event)" placeholder="Unggah Foto KTP" class="form-control bg-transparent @error('id_card') is-invalid @enderror" value="{{ old('id_card') }}"/>
                                <small>Unggah Foto KTP</small>
                                <br>
                                <small>Harap Unggah Foto KTP Yang Informasinya Dapat Dibaca Dengan Jelas</small>
                                @error('id_card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                                <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ asset('assets/dashboard/images/mentor_verifications/idcard.jpg') }}" alt="ID Card">
                                <br>
                                <img id="output" class="img-fluid rounded shadow mt-4" width="30%" src="{{ asset('assets/dashboard/images/mentor_verifications/uploaded-idcard.png') }}" alt="ID Card">
                            </div>
                            <div class="input-style-1">
                                <label for="selfie_with_id_card">Foto Selfie Dengan KTP</label>
                                <input type="file" name="selfie_with_id_card" accept="image/*" onchange="loadFile2(event)" placeholder="Unggah Foto Selfie Dengan KTP" class="form-control bg-transparent @error('selfie_with_id_card') is-invalid @enderror" value="{{ old('selfie_with_id_card') }}"/>
                                <small>Unggah Foto Selfie Dengan KTP</small>
                                <br>
                                <small>Harap Unggah Foto Selfie Dengan KTP Yang Informasinya Dapat Dibaca Dengan Jelas</small>
                                @error('selfie_with_id_card')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <br>
                                <img class="img-fluid rounded shadow mt-3" width="30%" src="{{ asset('assets/dashboard/images/mentor_verifications/selfie_idcard.png') }}" alt="ID Card">
                                <br>
                                <img id="output2" class="img-fluid rounded shadow mt-4" width="30%" src="{{ asset('assets/dashboard/images/mentor_verifications/uploaded-selfie_idcard.png') }}" alt="ID Card">
                            </div>
                            <div class="input-style-1">
                                <label for="resume">Resume</label>
                                <input type="file" name="resume" placeholder="Unggah Resume" class="form-control bg-transparent @error('resume') is-invalid @enderror" value="{{ old('resume') }}"/>
                                <small>Unggah Resume</small>
                                @error('resume')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="whatsapp_number">No. HP (WhatsApp)</label>
                                <input type="number" name="whatsapp_number" placeholder="Masukkan No. HP (WhatsApp)" class="form-control bg-transparent @error('whatsapp_number') is-invalid @enderror" value="{{ old('whatsapp_number') }}"/>
                                @error('whatsapp_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="facebook_profile_link">Link Profil Facebook (Opsional)</label>
                                <input type="text" name="facebook_profile_link" placeholder="Masukkan Link Profil Facebook" class="form-control bg-transparent @error('facebook_profile_link') is-invalid @enderror" value="{{ old('facebook_profile_link') }}"/>
                                @error('facebook_profile_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="instagram_profile_link">Link Profil Instagram (Opsional)</label>
                                <input type="text" name="instagram_profile_link" placeholder="Masukkan Link Profil Instagram" class="form-control bg-transparent @error('instagram_profile_link') is-invalid @enderror" value="{{ old('instagram_profile_link') }}"/>
                                @error('instagram_profile_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="linkedin_profile_link">Link Profil LinkedIn (Opsional)</label>
                                <input type="text" name="linkedin_profile_link" placeholder="Masukkan Link Profil LinkedIn" class="form-control bg-transparent @error('linkedin_profile_link') is-invalid @enderror" value="{{ old('linkedin_profile_link') }}"/>
                                @error('linkedin_profile_link')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="bank_account_number">No. Rekening Bank</label>
                                <input type="number" name="bank_account_number" placeholder="Masukkan No. Rekening Bank" class="form-control bg-transparent @error('bank_account_number') is-invalid @enderror" value="{{ old('bank_account_number') }}"/>
                                @error('bank_account_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="bank_account_name">Nama Pemilik Rekening Bank</label>
                                <input type="text" name="bank_account_name" placeholder="Masukkan Nama Pemilik Rekening Bank" class="form-control bg-transparent @error('bank_account_name') is-invalid @enderror" value="{{ old('bank_account_name') }}"/>
                                @error('bank_account_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1">
                                <label for="bank_name">Nama Bank</label>
                                <input type="text" name="bank_name" placeholder="Masukkan Nama Bank" class="form-control bg-transparent @error('bank_name') is-invalid @enderror" value="{{ old('bank_name') }}"/>
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
                                    Buat Verifikasi Mentor
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
    var loadFile = function(verification) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(verification.target.files[0]);
    };
    var loadFile2 = function(verification) {
        var output = document.getElementById('output2');
        output.src = URL.createObjectURL(verification.target.files[0]);
    };
</script>
@endpush