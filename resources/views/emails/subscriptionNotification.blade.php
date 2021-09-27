@component('mail::message')
    <h2>Notification From Company X</h2>

    <p>Dear {{ $details['subscriber_full_name'] }}</p>
    <p>Your subscription to {{ $details['service_type'] }} service has been {{ $details['verification_status'] }}</p>

{{--@component('mail::button', ['url' => ''])--}}{{--
Button Text
@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
