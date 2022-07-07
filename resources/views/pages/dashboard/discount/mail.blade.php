@component('mail::message')
# Promo Baru

Promo baru telah tersedia di website. Segera lihat detail promo melalui tombol di bawah

@component('mail::button', ['url' => route('discount.show', $hash->encodeHex($item->id))])
Detail Promo
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
