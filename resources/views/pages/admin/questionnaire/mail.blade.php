@component('mail::message')
# Kuesioner Baru

Kuesioner baru telah dikirim oleh pengunjung website. Segera lihat detail kuesioner melalui tombol di bawah

@component('mail::button', ['url' => route('admin.questionnaire.show', $hash->encodeHex($item->id))])
Detail Kuesioner
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
