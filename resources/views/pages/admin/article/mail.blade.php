@component('mail::message')
# Artikel Baru

Artikel baru telah dikirim dan memerlukan peninjauan. Segera lihat detail artikel melalui tombol di bawah

@component('mail::button', ['url' => route('admin.article.show', $hash->encodeHex($item->id))])
Detail Artikel
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
