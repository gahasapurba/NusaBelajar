@component('mail::message')
# Peninjauan Artikel Anda

@if ($item->is_accepted)
Selamat, artikel anda telah diterima untuk ditampilkan di website NusaBelajar. Segera lihat detail artikel melalui tombol di bawah
@else
Maaf, artikel anda telah ditolak untuk ditampilkan di website NusaBelajar. Segera lihat detail artikel melalui tombol di bawah
@endif

@component('mail::button', ['url' => route('dashboard.article.show', $hash->encodeHex($item->id))])
Detail Artikel
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
