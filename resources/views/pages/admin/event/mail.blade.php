@component('mail::message')
# Event Baru

Event baru telah dikirim dan memerlukan peninjauan. Segera lihat detail event melalui tombol di bawah

@component('mail::button', ['url' => route('admin.event.show', $hash->encodeHex($item->id))])
Detail Event
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
