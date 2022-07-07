@component('mail::message')
# Peninjauan Verifikasi Mentor Anda

@if ($item->is_accepted)
Selamat, verifikasi mentor anda telah diterima dan anda telah resmi menjadi mentor di website NusaBelajar. Segera lihat detail verifikasi mentor melalui tombol di bawah
@else
Maaf, verifikasi mentor anda telah ditolak. Segera lihat detail verifikasi mentor melalui tombol di bawah
@endif

@component('mail::button', ['url' => route('dashboard.mentor.verification.show', $hash->encodeHex($item->id))])
Detail Verifikasi Mentor
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
