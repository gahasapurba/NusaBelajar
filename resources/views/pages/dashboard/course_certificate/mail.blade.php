@component('mail::message')
# Sertifikat Diterbitkan

Sertifikat kelulusan anda pada sebuah kelas telah diterbitkan. Segera lihat detail sertifikat melalui tombol di bawah

@component('mail::button', ['url' => route('dashboard.course.certificate.show', $hash->encodeHex($item->id))])
Detail Sertifikat
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
