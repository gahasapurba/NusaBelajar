<!DOCTYPE html>
<html lang="id">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>NusaBelajar (Dashboard) - @yield('title')</title>
        {{-- Style --}}
        @stack('prepend-style')
        @include('includes.dashboard.style')
        @stack('addon-style')
    </head>
    <body>
        {{-- Sidebar --}}
        @include('includes.dashboard.sidebar')
        <main class="main-wrapper">
            {{-- Header --}}
            @include('includes.dashboard.header')
            {{-- Pages --}}
            <section class="section">
                <div class="container-fluid">
                    <div class="title-wrapper pt-30">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="title mb-30">
                                    <h2>@yield('title')</h2>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="breadcrumb-wrapper mb-30">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb">
                                                <a href="{{ route('dashboard.index') }}">Dashboard&nbsp;</a>
                                            </li>
                                            <li class="breadcrumb active" aria-current="page">
                                                / @yield('title')
                                            </li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        use RealRashid\SweetAlert\Facades\Alert;
                        if($errors->any())
                        {
                            alert()->error('Kesalahan Pengisian Data','Silahkan Ulangi Mengisi Data');
                        }
                    @endphp
                    @yield('content')
                </div>
            </section>
            {{-- Footer --}}
            @include('includes.dashboard.footer')
        </main>
        {{-- Theme --}}
        @include('includes.dashboard.theme')
        {{-- Script --}}
        @stack('prepend-script')
        @include('includes.dashboard.script')
        @stack('addon-script')
        {{-- Sweet Alert --}}
        @include('sweetalert::alert')
    </body>
</html>