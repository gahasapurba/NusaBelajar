<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="{{ route('homepage.index') }}">
            <img src="{{ asset('assets/dashboard/images/logo/logo.svg') }}" alt="logo" />
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
            {{-- Dashboard --}}
            <li class="nav-item {{ (request()->is('dashboard')) ? 'active' : '' }}">
                <a href="{{ route('dashboard.index') }}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            {{-- Daftar Notifikasi --}}
            <li class="nav-item {{ (request()->is('dashboard/notification*')) ? 'active' : '' }}">
                <a href="{{ route('dashboard.notification.index') }}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Daftar Notifikasi</span>
                </a>
            </li>
            {{-- Daftar Pengumuman --}}
            <li class="nav-item {{ (request()->is('dashboard/announcement*')) ? 'active' : '' }}">
                <a href="{{ route('dashboard.announcement.index') }}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Daftar Pengumuman</span>
                </a>
            </li>
            {{-- Ubah Profil --}}
            <li class="nav-item {{ (request()->is('dashboard/user*')) ? 'active' : '' }}">
                <a href="{{ route('dashboard.user.index') }}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Ubah Profil</span>
                </a>
            </li>
            {{-- Daftar Transaksi --}}
            <li class="nav-item {{ (request()->is('dashboard/checkout*')) ? 'active' : '' }}">
                <a href="{{ route('dashboard.checkout.index') }}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Daftar Transaksi</span>
                </a>
            </li>
            {{-- Divider --}}
            <span class="divider"><hr /></span>
            {{-- Kelas --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('dashboard/course*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_2" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Kelas</span>
                </a>
                <ul id="ddmenu_2" class="collapse {{ (request()->is('dashboard/course*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('dashboard.course.exam.answer.index') }}" class="{{ (request()->is('dashboard/course/exam/answer')) ? 'active' : '' }}">Daftar Jawaban Ujian Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.course.certificate.index') }}" class="{{ (request()->is('dashboard/course/certificate')) ? 'active' : '' }}">Daftar Sertifikat Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.course.member.index') }}" class="{{ (request()->is('dashboard/course/member')) ? 'active' : '' }}">Daftar Anggota Kelas</a>
                    </li>
                </ul>
            </li>
            {{-- Diskusi --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('dashboard/discussion*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_3" aria-controls="ddmenu_3" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Diskusi</span>
                </a>
                <ul id="ddmenu_3" class="collapse {{ (request()->is('dashboard/discussion*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('dashboard.discussion.index') }}" class="{{ (request()->is('dashboard/discussion')) ? 'active' : '' }}">Daftar Diskusi</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.discussion.create') }}" class="{{ (request()->is('dashboard/discussion/create')) ? 'active' : '' }}">Buat Diskusi</a>
                    </li>
                </ul>
            </li>
            {{-- Artikel --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('dashboard/article*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_1" aria-controls="ddmenu_1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Artikel</span>
                </a>
                <ul id="ddmenu_1" class="collapse {{ (request()->is('dashboard/article*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('dashboard.article.index') }}" class="{{ (request()->is('dashboard/article')) ? 'active' : '' }}">Daftar Artikel</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.article.create') }}" class="{{ (request()->is('dashboard/article/create')) ? 'active' : '' }}">Buat Artikel</a>
                    </li>
                </ul>
            </li>
            {{-- Divider --}}
            <span class="divider"><hr /></span>
            {{-- Pesan --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('dashboard/message*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_5" aria-controls="ddmenu_5" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Pesan</span>
                </a>
                <ul id="ddmenu_5" class="collapse {{ (request()->is('dashboard/message*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('dashboard.message.sended') }}" class="{{ (request()->is('dashboard/message/sended')) ? 'active' : '' }}">Daftar Pesan Terkirim</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.message.received') }}" class="{{ (request()->is('dashboard/message/received')) ? 'active' : '' }}">Daftar Pesan Masuk</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.message.create') }}" class="{{ (request()->is('dashboard/message/create')) ? 'active' : '' }}">Buat Pesan</a>
                    </li>
                </ul>
            </li>
            {{-- Verifikasi Mentor --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('dashboard/mentor/verification*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_4" aria-controls="ddmenu_4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Verifikasi Mentor</span>
                </a>
                <ul id="ddmenu_4" class="collapse {{ (request()->is('dashboard/mentor/verification*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('dashboard.mentor.verification.index') }}" class="{{ (request()->is('dashboard/mentor/verification')) ? 'active' : '' }}">Daftar Verifikasi Mentor</a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.mentor.verification.create') }}" class="{{ (request()->is('dashboard/mentor/verification/create')) ? 'active' : '' }}">Buat Verifikasi Mentor</a>
                    </li>
                </ul>
            </li>
            @if(Auth::user()->is_mentor)
                {{-- Divider --}}
                <span class="divider"><hr /></span>
                {{-- Daftar Transaksi Mentor --}}
                <li class="nav-item {{ (request()->is('dashboard/mentor/checkout*')) ? 'active' : '' }}">
                    <a href="{{ route('dashboard.mentor.checkout.index') }}">
                        <span class="icon">
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                            </svg>
                        </span>
                        <span class="text">Daftar Transaksi Mentor</span>
                    </a>
                </li>
                {{-- Kelas Mentor --}}
                <li class="nav-item nav-item-has-children">
                    <a href="#0" class="{{ (request()->is('dashboard/mentor/course*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_6" aria-controls="ddmenu_6" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                            </svg>
                        </span>
                        <span class="text">Kelas Mentor</span>
                    </a>
                    <ul id="ddmenu_6" class="collapse {{ (request()->is('dashboard/mentor/course*')) ? 'show' : '' }} dropdown-nav">
                        <li>
                            <a href="{{ route('dashboard.mentor.course.index') }}" class="{{ (request()->is('dashboard/mentor/course')) ? 'active' : '' }}">Daftar Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.subtopic.index') }}" class="{{ (request()->is('dashboard/mentor/course/subtopic')) ? 'active' : '' }}">Daftar Sub Topik Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.material.index') }}" class="{{ (request()->is('dashboard/mentor/course/material')) ? 'active' : '' }}">Daftar Materi Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.exam.index') }}" class="{{ (request()->is('dashboard/mentor/course/exam')) ? 'active' : '' }}">Daftar Soal Ujian Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.exam.answer.index') }}" class="{{ (request()->is('dashboard/mentor/course/exam/answer')) ? 'active' : '' }}">Daftar Jawaban Ujian Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.certificate.index') }}" class="{{ (request()->is('dashboard/mentor/course/certificate')) ? 'active' : '' }}">Daftar Sertifikat Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.member.index') }}" class="{{ (request()->is('dashboard/mentor/course/member')) ? 'active' : '' }}">Daftar Anggota Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.create') }}" class="{{ (request()->is('dashboard/mentor/course/create')) ? 'active' : '' }}">Buat Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.subtopic.create') }}" class="{{ (request()->is('dashboard/mentor/course/subtopic/create')) ? 'active' : '' }}">Buat Sub Topik Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.material.create') }}" class="{{ (request()->is('dashboard/mentor/course/material/create')) ? 'active' : '' }}">Buat Materi Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.exam.create') }}" class="{{ (request()->is('dashboard/mentor/course/exam/create')) ? 'active' : '' }}">Buat Soal Ujian Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.certificate.create') }}" class="{{ (request()->is('dashboard/mentor/course/certificate/create')) ? 'active' : '' }}">Buat Sertifikat Kelas</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.course.member.create') }}" class="{{ (request()->is('dashboard/mentor/course/member/create')) ? 'active' : '' }}">Buat Anggota Kelas</a>
                        </li>
                    </ul>
                </li>
                {{-- Event --}}
                <li class="nav-item nav-item-has-children">
                    <a href="#0" class="{{ (request()->is('dashboard/mentor/event*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_7" aria-controls="ddmenu_7" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="icon">
                            <svg width="22" height="22" viewBox="0 0 22 22">
                                <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                            </svg>
                        </span>
                        <span class="text">Event</span>
                    </a>
                    <ul id="ddmenu_7" class="collapse {{ (request()->is('dashboard/mentor/event*')) ? 'show' : '' }} dropdown-nav">
                        <li>
                            <a href="{{ route('dashboard.mentor.event.index') }}" class="{{ (request()->is('dashboard/mentor/event')) ? 'active' : '' }}">Daftar Event</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.mentor.event.create') }}" class="{{ (request()->is('dashboard/mentor/event/create')) ? 'active' : '' }}">Buat Event</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
</aside>
<div class="overlay"></div>