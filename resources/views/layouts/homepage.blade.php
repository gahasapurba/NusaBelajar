<!DOCTYPE html>
<html class="no-js" lang="id">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title>NusaBelajar - @yield('title')</title>
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        {{-- Style --}}
        @stack('prepend-style')
        @include('includes.homepage.style')
        @stack('addon-style')
    </head>
    <body>
        {{-- Header --}}
        @include('includes.homepage.header')
        {{-- Pages --}}
        @if(!request()->is('/'))
        <div class="breadcrumbs overlay">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 offset-lg-2 col-md-12 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">@yield('title')</h1>
                        </div>
                        <ul class="breadcrumb-nav">
                            <li><a href="{{ route('homepage.index') }}">Beranda</a></li>
                            <li>@yield('title')</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @php
            use RealRashid\SweetAlert\Facades\Alert;
            if($errors->any())
            {
                alert()->error('Kesalahan Pengisian Data','Silahkan Ulangi Mengisi Data');
            }
        @endphp
        @yield('content')
        {{-- Footer --}}
        @include('includes.homepage.footer')
        {{-- Script --}}
        @stack('prepend-script')
        @include('includes.homepage.script')
        @stack('addon-script')
        {{-- Sweet Alert --}}
        @include('sweetalert::alert')
    </body>
</html>