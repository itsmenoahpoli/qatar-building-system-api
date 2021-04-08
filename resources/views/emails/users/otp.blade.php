@component('mail::message') Hi, <b>{{ $user_name }}</b>

### Below is your one-time-passcode

<br />

@if($otp_type === "verify")
<small> Your account verification OTP will expire at {{ $expires_at }} </small>
@else
<small> Your login verification OTP will expire at {{ $expires_at }} </small>
@endif @component('mail::panel')
{{ $otp_code }}
@endcomponent

<small>
	We're here to help you if you need it. If you have any concerns please
	contact us at support@qatar-ebpms.com or visit our
	<a href="https://google.com">support page</a>
</small>

<div class="mail-footer"></div>
@endcomponent
