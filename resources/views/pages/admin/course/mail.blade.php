@component('mail::message')
# Kelas Baru

Kelas baru telah dikirim dan memerlukan peninjauan. Segera lihat detail kelas melalui tombol di bawah

@component('mail::button', ['url' => route('admin.course.show', $hash->encodeHex($item->id))])
Detail Kelas
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
