<?php

namespace App\Traits;

use App\Mail\Payments\PaymentLinkUrl as PaymentLinkUrlMail;
use Mail as SendMail;

Trait Mail {
  public function send_payment_url_to_client($email, array $data) {
    try {
      SendMail::to($email)->send(new PaymentLinkUrlMail([
        'message' => $data['message'],
        'user_name' => $data['user_name'],
        'payment_link' => $data['payment_link'], 
      ]));
    } catch(Exception $e) {
      throw new Exception('Failed to send payment link mail');
    }
  }
}