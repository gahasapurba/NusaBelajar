@component('mail::message')
# Pengumuman Baru

Pengumuman baru telah dikirim oleh administrator website. Segera lihat detail pengumuman melalui tombol di bawah

@component('mail::button', ['url' => route('dashboard.announcement.show', $hash->encodeHex($item->id))])
Detail Pengumuman
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
