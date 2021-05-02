@component('mail::message') Hi, <b>{{ $user_name }}</b>

Provided is your default password for your created KIC E-BPMS Account

<br />

<small>Your password</small>
@component('mail::panel')
{{ $password }}
@endcomponent

<small>
	Sign-in here
	<a href="https://dashboard.e-bpms.site/">https://dashboard.e-bpms.site/</a>
</small>

<small>
	We're here to help you if you need it. If you have any concerns please
	contact us at info@e-bpms.site or visit our
	<a href="https://app.e-bpms.site/support">support page</a>
</small>

<div class="mail-footer"></div>
@endcomponent
