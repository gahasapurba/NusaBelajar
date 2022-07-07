@component('mail::message')
# Verifikasi Mentor Baru

Verifikasi mentor baru telah dikirim dan memerlukan peninjauan. Segera lihat detail verifikasi mentor melalui tombol di bawah

@component('mail::button', ['url' => route('admin.mentor.verification.show', $hash->encodeHex($item->id))])
Detail Verifikasi Mentor
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
