@component('mail::message')
# Komentar Baru Pada Artikel Anda

Komentar baru telah dikirim oleh seseorang pada artikel anda yang berjudul {{$item->title}}. Segera lihat detail komentar melalui tombol di bawah

@component('mail::button', ['url' => route('article.show', $item->slug)])
Detail Komentar
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
