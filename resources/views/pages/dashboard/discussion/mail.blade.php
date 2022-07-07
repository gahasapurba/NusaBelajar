@component('mail::message')
# Peninjauan Diskusi Anda

@if ($item->is_accepted)
Selamat, diskusi anda telah diterima untuk ditampilkan di website NusaBelajar. Segera lihat detail diskusi melalui tombol di bawah
@else
Maaf, diskusi anda telah ditolak untuk ditampilkan di website NusaBelajar. Segera lihat detail diskusi melalui tombol di bawah
@endif

@component('mail::button', ['url' => route('dashboard.discussion.show', $hash->encodeHex($item->id))])
Detail Diskusi
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
