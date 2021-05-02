<?php

namespace App\Mail\Payments;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentLinkUrl extends Mailable
{
    use Queueable, SerializesModels;

    private $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->content = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      return $this->markdown('emails.payments.payment-link-url')
      ->subject('KIC E-BPMS - Application Record Notification')
      ->with([
        'message' => $this->content['message'],
        'user_name' => $this->content['user_name'],
        'payment_link' => $this->content['payment_link'],
      ]);
    }
}
