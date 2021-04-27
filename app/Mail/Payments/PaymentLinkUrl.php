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
      ->subject('Application Payment Link')
      ->with([
        'user_name' => $this->content['user_name'],
        'payment_link' => $this->content['payment_link'],
      ]);
    }
}
