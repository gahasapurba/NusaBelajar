@component('mail::message')
# Pendaftaran Kelas

Selamat! anda telah diterima untuk didaftarkan pada sebuah kelas. Segera lihat materi kelas melalui tombol di bawah

@component('mail::button', ['url' => route('course.material.show', $item->slug)])
Materi Kelas
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
