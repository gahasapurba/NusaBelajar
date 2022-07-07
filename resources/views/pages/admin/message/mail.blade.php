@component('mail::message')
# Pesan Baru

Pesan baru telah dikirim oleh {$item->message_creator->name} kepada anda. Segera lihat detail pesan melalui tombol di bawah

@component('mail::button', ['url' => route('admin.message.show', $hash->encodeHex($item->id))])
Detail Pesan
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
