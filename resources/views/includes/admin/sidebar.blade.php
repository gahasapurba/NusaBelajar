<aside class="sidebar-nav-wrapper">
    <div class="navbar-logo">
        <a href="{{ route('homepage.index') }}">
            <img src="{{ asset('assets/dashboard/images/logo/logo.svg') }}" alt="logo" />
        </a>
    </div>
    <nav class="sidebar-nav">
        <ul>
            {{-- Dashboard --}}
            <li class="nav-item {{ (request()->is('admin')) ? 'active' : '' }}">
                <a href="{{ route('admin.index') }}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            {{-- Buat Email --}}
            <li class="nav-item {{ (request()->is('admin/email/broadcast/create')) ? 'active' : '' }}">
                <a href="{{ route('admin.email.broadcast.create') }}">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Buat Email</span>
                </a>
            </li>
            {{-- Daftar Pesan Kontak --}}
            <li class="nav-item">
                <a href="https://docs.google.com/spreadsheets/d/1v2dWhSx_-F3H_nhfuUF8Xl1Mj-sPujzRFzT3Bskfnk8" target="_blank">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Daftar Pesan Kontak</span>
                </a>
            </li>
            {{-- Divider --}}
            <span class="divider"><hr /></span>
            {{-- Notifikasi --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/notification*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_11" aria-controls="ddmenu_11" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Notifikasi</span>
                </a>
                <ul id="ddmenu_11" class="collapse {{ (request()->is('admin/notification*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.notification.index') }}" class="{{ (request()->is('admin/notification')) ? 'active' : '' }}">Daftar Notifikasi</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.notification.trash') }}" class="{{ (request()->is('admin/notification/trash')) ? 'active' : '' }}">Arsip Notifikasi</a>
                    </li>
                </ul>
            </li>
            {{-- Pesan --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/message*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_10" aria-controls="ddmenu_10" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Pesan</span>
                </a>
                <ul id="ddmenu_10" class="collapse {{ (request()->is('admin/message*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.message.index') }}" class="{{ (request()->is('admin/message')) ? 'active' : '' }}">Daftar Pesan</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.message.sended') }}" class="{{ (request()->is('admin/message/sended')) ? 'active' : '' }}">Daftar Pesan Terkirim</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.message.received') }}" class="{{ (request()->is('admin/message/received')) ? 'active' : '' }}">Daftar Pesan Masuk</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.message.create') }}" class="{{ (request()->is('admin/message/create')) ? 'active' : '' }}">Buat Pesan</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.message.trash') }}" class="{{ (request()->is('admin/message/trash')) ? 'active' : '' }}">Arsip Pesan</a>
                    </li>
                </ul>
            </li>
            {{-- Pengumuman --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/announcement*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_1" aria-controls="ddmenu_1" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Pengumuman</span>
                </a>
                <ul id="ddmenu_1" class="collapse {{ (request()->is('admin/announcement*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.announcement.index') }}" class="{{ (request()->is('admin/announcement')) ? 'active' : '' }}">Daftar Pengumuman</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.announcement.create') }}" class="{{ (request()->is('admin/announcement/create')) ? 'active' : '' }}">Buat Pengumuman</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.announcement.trash') }}" class="{{ (request()->is('admin/announcement/trash')) ? 'active' : '' }}">Arsip Pengumuman</a>
                    </li>
                </ul>
            </li>
            {{-- Verifikasi Mentor --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/mentor/verification*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_9" aria-controls="ddmenu_9" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Verifikasi Mentor</span>
                </a>
                <ul id="ddmenu_9" class="collapse {{ (request()->is('admin/mentor/verification*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.mentor.verification.index') }}" class="{{ (request()->is('admin/mentor/verification')) ? 'active' : '' }}">Daftar Verifikasi Mentor</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.mentor.verification.trash') }}" class="{{ (request()->is('admin/mentor/verification/trash')) ? 'active' : '' }}">Arsip Verifikasi Mentor</a>
                    </li>
                </ul>
            </li>
            {{-- Pengguna --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/user*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_13" aria-controls="ddmenu_13" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Pengguna</span>
                </a>
                <ul id="ddmenu_13" class="collapse {{ (request()->is('admin/user*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.user.index') }}" class="{{ (request()->is('admin/user')) ? 'active' : '' }}">Daftar Pengguna</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.user.trash') }}" class="{{ (request()->is('admin/user/trash')) ? 'active' : '' }}">Arsip Pengguna</a>
                    </li>
                </ul>
            </li>
            {{-- Transaksi --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/checkout*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_3" aria-controls="ddmenu_3" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Transaksi</span>
                </a>
                <ul id="ddmenu_3" class="collapse {{ (request()->is('admin/checkout*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.checkout.index') }}" class="{{ (request()->is('admin/checkout')) ? 'active' : '' }}">Daftar Transaksi</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.checkout.trash') }}" class="{{ (request()->is('admin/checkout/trash')) ? 'active' : '' }}">Arsip Transaksi</a>
                    </li>
                </ul>
            </li>
            {{-- Email Berlangganan --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/email/subscription*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_7" aria-controls="ddmenu_7" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Email Berlangganan</span>
                </a>
                <ul id="ddmenu_7" class="collapse {{ (request()->is('admin/email/subscription*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.email.subscription.index') }}" class="{{ (request()->is('admin/email/subscription')) ? 'active' : '' }}">Daftar Email Berlangganan</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.email.subscription.trash') }}" class="{{ (request()->is('admin/email/subscription/trash')) ? 'active' : '' }}">Arsip Email Berlangganan</a>
                    </li>
                </ul>
            </li>
            {{-- Kuesioner --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/questionnaire*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_12" aria-controls="ddmenu_12" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Kuesioner</span>
                </a>
                <ul id="ddmenu_12" class="collapse {{ (request()->is('admin/questionnaire*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.questionnaire.index') }}" class="{{ (request()->is('admin/questionnaire')) ? 'active' : '' }}">Daftar Kuesioner</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.questionnaire.trash') }}" class="{{ (request()->is('admin/questionnaire/trash')) ? 'active' : '' }}">Arsip Kuesioner</a>
                    </li>
                </ul>
            </li>
            {{-- Divider --}}
            <span class="divider"><hr /></span>
            {{-- Kelas --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/course*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_4" aria-controls="ddmenu_4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Kelas</span>
                </a>
                <ul id="ddmenu_4" class="collapse {{ (request()->is('admin/course*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.course.index') }}" class="{{ (request()->is('admin/course')) ? 'active' : '' }}">Daftar Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.category.index') }}" class="{{ (request()->is('admin/course/category')) ? 'active' : '' }}">Daftar Kategori Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.subtopic.index') }}" class="{{ (request()->is('admin/course/subtopic')) ? 'active' : '' }}">Daftar Sub Topik Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.material.index') }}" class="{{ (request()->is('admin/course/material')) ? 'active' : '' }}">Daftar Materi Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.exam.index') }}" class="{{ (request()->is('admin/course/exam')) ? 'active' : '' }}">Daftar Soal Ujian Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.exam.answer.index') }}" class="{{ (request()->is('admin/course/exam/answer')) ? 'active' : '' }}">Daftar Jawaban Ujian Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.certificate.index') }}" class="{{ (request()->is('admin/course/certificate')) ? 'active' : '' }}">Daftar Sertifikat Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.member.index') }}" class="{{ (request()->is('admin/course/member')) ? 'active' : '' }}">Daftar Anggota Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.category.create') }}" class="{{ (request()->is('admin/course/category/create')) ? 'active' : '' }}">Buat Kategori Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.certificate.create') }}" class="{{ (request()->is('admin/course/certificate/create')) ? 'active' : '' }}">Buat Sertifikat Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.member.create') }}" class="{{ (request()->is('admin/course/member/create')) ? 'active' : '' }}">Buat Anggota Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.trash') }}" class="{{ (request()->is('admin/course/trash')) ? 'active' : '' }}">Arsip Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.category.trash') }}" class="{{ (request()->is('admin/course/category/trash')) ? 'active' : '' }}">Arsip Kategori Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.subtopic.trash') }}" class="{{ (request()->is('admin/course/subtopic/trash')) ? 'active' : '' }}">Arsip Sub Topik Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.material.trash') }}" class="{{ (request()->is('admin/course/material/trash')) ? 'active' : '' }}">Arsip Materi Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.exam.trash') }}" class="{{ (request()->is('admin/course/exam/trash')) ? 'active' : '' }}">Arsip Soal Ujian Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.exam.answer.trash') }}" class="{{ (request()->is('admin/course/exam/answer/trash')) ? 'active' : '' }}">Arsip Jawaban Ujian Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.certificate.trash') }}" class="{{ (request()->is('admin/course/certificate/trash')) ? 'active' : '' }}">Arsip Sertifikat Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.member.trash') }}" class="{{ (request()->is('admin/course/member/trash')) ? 'active' : '' }}">Arsip Anggota Kelas</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.course.review.trash') }}" class="{{ (request()->is('admin/course/review/trash')) ? 'active' : '' }}">Arsip Review Kelas</a>
                    </li>
                </ul>
            </li>
            {{-- Event --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/event*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_8" aria-controls="ddmenu_8" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Event</span>
                </a>
                <ul id="ddmenu_8" class="collapse {{ (request()->is('admin/event*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.event.index') }}" class="{{ (request()->is('admin/event')) ? 'active' : '' }}">Daftar Event</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.event.category.index') }}" class="{{ (request()->is('admin/event/category')) ? 'active' : '' }}">Daftar Kategori Event</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.event.category.create') }}" class="{{ (request()->is('admin/event/category/create')) ? 'active' : '' }}">Buat Kategori Event</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.event.trash') }}" class="{{ (request()->is('admin/event/trash')) ? 'active' : '' }}">Arsip Event</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.event.category.trash') }}" class="{{ (request()->is('admin/event/category/trash')) ? 'active' : '' }}">Arsip Kategori Event</a>
                    </li>
                </ul>
            </li>
            {{-- Diskusi --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/discussion*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_6" aria-controls="ddmenu_6" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Diskusi</span>
                </a>
                <ul id="ddmenu_6" class="collapse {{ (request()->is('admin/discussion*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.discussion.index') }}" class="{{ (request()->is('admin/discussion')) ? 'active' : '' }}">Daftar Diskusi</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.discussion.category.index') }}" class="{{ (request()->is('admin/discussion/category')) ? 'active' : '' }}">Daftar Kategori Diskusi</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.discussion.category.create') }}" class="{{ (request()->is('admin/discussion/category/create')) ? 'active' : '' }}">Buat Kategori Diskusi</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.discussion.trash') }}" class="{{ (request()->is('admin/discussion/trash')) ? 'active' : '' }}">Arsip Diskusi</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.discussion.category.trash') }}" class="{{ (request()->is('admin/discussion/category/trash')) ? 'active' : '' }}">Arsip Kategori Diskusi</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.discussion.answer.trash') }}" class="{{ (request()->is('admin/discussion/answer/trash')) ? 'active' : '' }}">Arsip Jawaban Diskusi</a>
                    </li>
                </ul>
            </li>
            {{-- Artikel --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/article*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_2" aria-controls="ddmenu_2" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Artikel</span>
                </a>
                <ul id="ddmenu_2" class="collapse {{ (request()->is('admin/article*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.article.index') }}" class="{{ (request()->is('admin/article')) ? 'active' : '' }}">Daftar Artikel</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.article.category.index') }}" class="{{ (request()->is('admin/article/category')) ? 'active' : '' }}">Daftar Kategori Artikel</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.article.tag.index') }}" class="{{ (request()->is('admin/article/tag')) ? 'active' : '' }}">Daftar Tag Artikel</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.article.tagged.index') }}" class="{{ (request()->is('admin/article/tagged')) ? 'active' : '' }}">Daftar Artikel Yang Ditag</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.article.category.create') }}" class="{{ (request()->is('admin/article/category/create')) ? 'active' : '' }}">Buat Kategori Artikel</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.article.tag.create') }}" class="{{ (request()->is('admin/article/tag/create')) ? 'active' : '' }}">Buat Tag Artikel</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.article.trash') }}" class="{{ (request()->is('admin/article/trash')) ? 'active' : '' }}">Arsip Artikel</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.article.category.trash') }}" class="{{ (request()->is('admin/article/category/trash')) ? 'active' : '' }}">Arsip Kategori Artikel</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.article.tag.trash') }}" class="{{ (request()->is('admin/article/tag/trash')) ? 'active' : '' }}">Arsip Tag Artikel</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.article.tagged.trash') }}" class="{{ (request()->is('admin/article/tagged/trash')) ? 'active' : '' }}">Arsip Artikel Yang Ditag</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.article.comment.trash') }}" class="{{ (request()->is('admin/article/comment/trash')) ? 'active' : '' }}">Arsip Komentar Artikel</a>
                    </li>
                </ul>
            </li>
            {{-- Promo --}}
            <li class="nav-item nav-item-has-children">
                <a href="#0" class="{{ (request()->is('admin/discount*')) ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#ddmenu_5" aria-controls="ddmenu_5" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="icon">
                        <svg width="22" height="22" viewBox="0 0 22 22">
                            <path d="M17.4167 4.58333V6.41667H13.75V4.58333H17.4167ZM8.25 4.58333V10.0833H4.58333V4.58333H8.25ZM17.4167 11.9167V17.4167H13.75V11.9167H17.4167ZM8.25 15.5833V17.4167H4.58333V15.5833H8.25ZM19.25 2.75H11.9167V8.25H19.25V2.75ZM10.0833 2.75H2.75V11.9167H10.0833V2.75ZM19.25 10.0833H11.9167V19.25H19.25V10.0833ZM10.0833 13.75H2.75V19.25H10.0833V13.75Z" />
                        </svg>
                    </span>
                    <span class="text">Promo</span>
                </a>
                <ul id="ddmenu_5" class="collapse {{ (request()->is('admin/discount*')) ? 'show' : '' }} dropdown-nav">
                    <li>
                        <a href="{{ route('admin.discount.index') }}" class="{{ (request()->is('admin/discount')) ? 'active' : '' }}">Daftar Promo</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.discount.create') }}" class="{{ (request()->is('admin/discount/create')) ? 'active' : '' }}">Buat Promo</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.discount.trash') }}" class="{{ (request()->is('admin/discount/trash')) ? 'active' : '' }}">Arsip Promo</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
<div class="overlay"></div>