@php
    $notifications = App\Models\Notification::where('receiver_users_id', Auth::user()->id)->latest()->limit(3)->get();
    $messages = App\Models\Message::where('receiver_users_id', Auth::user()->id)->latest()->limit(3)->get();
    $hash = new Hashids\Hashids('', 10);
@endphp
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-6">
                <div class="header-left d-flex align-items-center">
                    <div class="menu-toggle-btn mr-20">
                        <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                            <i class="lni lni-chevron-left me-2"></i> Menu
                        </button>
                    </div>
                    <div class="header-search d-none d-md-flex">
                        <div id="google_translate_element"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-6">
                <div class="header-right">
                    <div class="notification-box ml-15 d-none d-md-flex">
                        <button class="dropdown-toggle" type="button" id="notification" data-bs-toggle="dropdown" aria-expanded="false" onclick="remove_dot1()">
                            <i class="lni lni-alarm"></i>
                            <span id="dot1"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notification">
                            @forelse ($notifications as $notification)
                                <li>
                                    <a
                                    @if ($notification->type == 'dashboard.announcement.index')
                                        href="{{ route('dashboard.announcement.index') }}"
                                    @elseif ($notification->type == 'article.index')
                                        href="{{ route('article.index') }}"
                                    @elseif ($notification->type == 'dashboard.course.certificate.index')
                                        href="{{ route('dashboard.course.certificate.index') }}"
                                    @elseif ($notification->type == 'dashboard.course.member.index')
                                        href="{{ route('dashboard.course.member.index') }}"
                                    @elseif ($notification->type == 'course.index')
                                        href="{{ route('course.index') }}"
                                    @elseif ($notification->type == 'discussion.index')
                                        href="{{ route('discussion.index') }}"
                                    @elseif ($notification->type == 'dashboard.message.received')
                                        href="{{ route('dashboard.message.received') }}"
                                    @elseif ($notification->type == 'dashboard.mentor.course.exam.answer.index')
                                        href="{{ route('dashboard.mentor.course.exam.answer.index') }}"
                                    @elseif ($notification->type == 'dashboard.article.index')
                                        href="{{ route('dashboard.article.index') }}"
                                    @elseif ($notification->type == 'dashboard.mentor.course.index')
                                        href="{{ route('dashboard.mentor.course.index') }}"
                                    @elseif ($notification->type == 'dashboard.discussion.index')
                                        href="{{ route('dashboard.discussion.index') }}"
                                    @elseif ($notification->type == 'dashboard.mentor.event.index')
                                        href="{{ route('dashboard.mentor.event.index') }}"
                                    @elseif ($notification->type == 'dashboard.mentor.verification.index')
                                        href="{{ route('dashboard.mentor.verification.index') }}"
                                    @else
                                        href="#"
                                    @endif
                                    >
                                        <div class="content">
                                            <h6>
                                                {{ $notification->title }}
                                                <span
                                                @if ($notification->subtitle == 'perlu ditinjau')
                                                    class="text-warning"
                                                @elseif ($notification->subtitle == 'perlu dilihat')
                                                    class="text-primary"
                                                @elseif ($notification->subtitle == 'telah diterima')
                                                    class="text-success"
                                                @elseif ($notification->subtitle == 'telah ditolak')
                                                    class="text-danger"
                                                @else
                                                    class="text-info"
                                                @endif
                                                >
                                                {{ $notification->subtitle }}
                                                </span>
                                            </h6>
                                            <p>
                                                {{ $notification->content }}
                                            </p>
                                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <a href="#">
                                        <div class="content">
                                            <p>
                                                Tidak ada notifikasi
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="header-message-box ml-15 d-none d-md-flex">
                        <button class="dropdown-toggle" type="button" id="message" data-bs-toggle="dropdown" aria-expanded="false"onclick="remove_dot2()">
                            <i class="lni lni-envelope"></i>
                            <span id="dot2"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="message">
                            @forelse ($messages as $message)
                                <li>
                                    <a href="{{ route('admin.message.show', $hash->encodeHex($message->id)) }}">
                                        <div class="image">
                                            @if (Str::startsWith($message->sender->avatar, 'upload/avatar/'))
                                                <img src="{{ Storage::url($message->sender->avatar) }}" alt="Profile Photo" />
                                            @elseif (!$message->sender->avatar)
                                                <img src="https://ui-avatars.com/api/?name={{ $message->sender->name }}" alt="Profile Photo" />
                                            @else
                                                <img src="{{ $message->sender->avatar }}" alt="Profile Photo" />
                                            @endif
                                        </div>
                                        <div class="content">
                                            <h6>{{ $message->sender->name }}</h6>
                                            <span>{{ $message->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <a href="#">
                                        <div class="content">
                                            <p>
                                                Tidak ada pesan
                                            </p>
                                        </div>
                                    </a>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="profile-box ml-15">
                        <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-info">
                                <div class="info">
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <div class="image">
                                        @if (Str::startsWith(Auth::user()->avatar, 'upload/avatar/'))
                                            <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Profile Photo" />
                                        @elseif (!Auth::user()->avatar)
                                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Profile Photo" />
                                        @else
                                            <img src="{{ Auth::user()->avatar }}" alt="Profile Photo" />
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <i class="lni lni-chevron-down"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                            <li>
                                <a href="{{ route('dashboard.user.index') }}">
                                    <i class="lni lni-user"></i> Ubah Profil
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('dashboard.message.received') }}">
                                    <i class="lni lni-inbox"></i> Pesan Masuk
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="lni lni-exit"></i> Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>