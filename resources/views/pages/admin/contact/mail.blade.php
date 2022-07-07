@component('mail::message')
# Pesan Baru Dari Contact Form

Pesan baru telah dikirim oleh seseorang melalui form contact di website NusaBelajar. Segera lihat detail pesan melalui tombol di bawah

@component('mail::button', ['url' => 'https://docs.google.com/spreadsheets/d/1v2dWhSx_-F3H_nhfuUF8Xl1Mj-sPujzRFzT3Bskfnk8'])
Detail Pesan
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
