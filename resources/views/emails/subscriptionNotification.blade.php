@component('mail::message')
{{ $details['Title'] }}

Dear {{ $subscriber_full_name }};<br>
Your service



{{--@component('mail::button', ['url' => ''])--}}{{--
Button Text
@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
