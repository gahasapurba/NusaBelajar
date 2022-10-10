@component('mail::message')
# Peninjauan Artikel Anda

Artikel anda telah selesai ditinjau oleh administrator. Segera lihat detail hasil peninjauan artikel melalui tombol di bawah

@component('mail::button', ['url' => route('dashboard.article.show', $hash->encodeHex($item->id))])
Detail Artikel
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
