<?php

namespace App\Traits;

use App\Mail\Payments\PaymentLinkUrl as PaymentLinkUrlMail;
use Mail as SendMail;

Trait Mail {
  public function send_payment_url_to_client($email, array $data) {
    SendMail::to($email)->send(new PaymentLinkUrlMail([
      'user_name' => $data['user_name'],
      'payment_link' => $data['payment_link'], 
    ]));
  }
}