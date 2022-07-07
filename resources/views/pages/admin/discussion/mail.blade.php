@component('mail::message')
# Diskusi Baru

Diskusi baru telah dikirim dan memerlukan peninjauan. Segera lihat detail diskusi melalui tombol di bawah

@component('mail::button', ['url' => route('admin.discussion.show', $hash->encodeHex($item->id))])
Detail Diskusi
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
