<x-mail::message>
# {{ $data['title'] }}

{!! nl2br($data['body']) !!}

Üdvözlettel,<br>
{{ config('app.name') }}
</x-mail::message>
