@extends('layouts.admin')
@section('title')
    Detail Promo
@endsection
@section('content')
<div class="form-layout-wrapper">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card-style mb-30">
                <h6 class="mb-25">Detail Promo</h6>
                <div class="row">
                    <div class="col-12">
                        <div class="input-style-1">
                            <label for="name">Nama Promo</label>
                            <input type="text" name="name" class="bg-transparent" value="{{ $item->name }}" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="description">Deskripsi Promo</label>
                            {!! $item->description !!}
                        </div>
                        <div class="input-style-1">
                            <label for="percentage">Persenan Promo</label>
                            <input type="text" name="percentage" class="bg-transparent" value="{{ $item->percentage }}%" readonly/>
                        </div>
                        <div class="input-style-1">
                            <label for="code">Kode Promo</label>
                            <input type="text" name="code" class="bg-transparent" value="{{ $item->code }}" readonly/>
                        </div>
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
                            <a href="{{ route('admin.discount.index') }}" class="main-btn primary-btn-outline m-2">
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