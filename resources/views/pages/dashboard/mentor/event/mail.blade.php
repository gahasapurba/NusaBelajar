@component('mail::message')
# Peninjauan Event Anda

@if ($item->is_accepted)
Selamat, event anda telah diterima untuk ditampilkan di website NusaBelajar. Segera lihat detail event melalui tombol di bawah
@else
Maaf, event anda telah ditolak untuk ditampilkan di website NusaBelajar. Segera lihat detail event melalui tombol di bawah
@endif

@component('mail::button', ['url' => route('dashboard.mentor.event.show', $hash->encodeHex($item->id))])
Detail Event
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
