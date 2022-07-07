@component('mail::message')
# Berlangganan di NusaBelajar

Terima kasih telah berlangganan di platform NusaBelajar menggunakan email {{$item->email}}. Nantikan berbagai informasi dan penawaran menarik dari kami

@component('mail::button', ['url' => route('homepage.index')])
Kembali Ke Beranda
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
