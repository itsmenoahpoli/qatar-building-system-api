<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class Otp extends Mailable
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
        return $this->markdown('emails.users.otp')
                    ->subject('One-Time-Passcode')
                    ->with([
                      'otp_code' => $this->content['otp_code'],
                      'user_name' => $this->content['user_name'],
                      'expires_at' => Carbon::parse($this->content['expires_at'])->format('F d, Y - l h:i A')
                    ]);
    }
}
