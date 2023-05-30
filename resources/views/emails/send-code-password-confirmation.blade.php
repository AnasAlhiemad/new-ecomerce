@component('mail::message')
<h1>We have received your request to confirmation your account password</h1>
<p>You can use the following code to confirmation your account:</p>

@component('mail::panel')
{{ $code }}
@endcomponent

<p>The allowed duration of the code is one hour from the time the message was sent</p>
@endcomponent

