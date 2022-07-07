@component('mail::message')
# Peninjauan Kelas Anda

@if ($item->is_accepted)
Selamat, kelas anda telah diterima untuk ditampilkan di website NusaBelajar. Segera lihat detail kelas melalui tombol di bawah
@else
Maaf, kelas anda telah ditolak untuk ditampilkan di website NusaBelajar. Segera lihat detail kelas melalui tombol di bawah
@endif

@component('mail::button', ['url' => route('dashboard.mentor.course.show', $hash->encodeHex($item->id))])
Detail Kelas
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
