@component('mail::message')
# {{ $request->title }}

{!! $request->message !!}

@component('mail::button', ['url' => $request->button_link])
{{ $request->button_text }}
@endcomponent

Terima Kasih,<br>
{{ config('app.name') }}
@endcomponent
