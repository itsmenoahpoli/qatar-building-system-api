@component('mail::message') Hi, <b>{{ $user_name }}</b>

{{ $message ?? "Please click or follow the URL below to proceed to your payment" }}

<br />

<small>Your payment link</small>
@component('mail::panel')
<a href="{{ $payment_link }}" target="_blank">{{ $payment_link }}</a>

@endcomponent

<small>
	We're here to help you if you need it. If you have any concerns please
	contact us at info@e-bpms.site or visit our
	<a href="https://app.e-bpms.site/support">support page</a>
</small>

<div class="mail-footer"></div>
@endcomponent
