<div class="preloader">
    <div class="preloader-inner">
        <div class="preloader-icon">
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<header class="header navbar-area">
    <div class="toolbar-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="toolbar-social">
                        <ul>
                            <li>
                                <span class="title">Ikuti Kami Di : </span>
                            </li>
                            <li>
                                <a href="https://facebook.com/institutteknologidel" target="_blank">
                                    <i class="lni lni-facebook-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/institut_del" target="_blank">
                                    <i class="lni lni-twitter-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://instagram.com/it.del" target="_blank">
                                    <i class="lni lni-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://linkedin.com/school/institut-teknologi-del" target="_blank">
                                    <i class="lni lni-linkedin-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://youtube.com/channel/UC_X-wXdXDmZ2AyUD5zlS17g" target="_blank">
                                    <i class="lni lni-youtube"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="toolbar-login">
                        <div class="button">
                            @auth
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                @if(Auth::user()->is_admin)
                                    <a href="{{ route('admin.index') }}" class="btn">Dashboard</a>
                                @else
                                    <a href="{{ route('dashboard.index') }}" class="btn">Dashboard</a>
                                @endif
                            @else
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Buat Akun</a>
                                @endif
                                <a href="{{ route('login') }}" class="btn">Masuk</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="nav-inner">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="{{ route('homepage.index') }}">
                            <img src="{{ asset('assets/homepage/images/logo/logo.svg') }}" alt="Logo">
                        </a>
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="{{ (request()->is('/')) ? 'active' : '' }}" href="{{ route('homepage.index') }}">Beranda</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ (request()->is('/course*')) ? 'active' : '' }}" href="{{ route('course.index') }}">Kelas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ (request()->is('/event*')) ? 'active' : '' }}" href="{{ route('event.index') }}">Event</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ (request()->is('/discussion*')) ? 'active' : '' }}" href="{{ route('discussion.index') }}">Forum Diskusi</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ (request()->is('/article*')) ? 'active' : '' }}" href="{{ route('article.index') }}">Blog</a>
                                </li>
                                <li class="nav-item">
                                    <a class="{{ (request()->is('/discount*')) ? 'active' : '' }}" href="{{ route('discount.index') }}">Promo</a>
                                </li>
                            </ul>
                            <form class="d-flex search-form">
                                <div id="google_translate_element"></div>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>