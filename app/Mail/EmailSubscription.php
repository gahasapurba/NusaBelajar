<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailSubscription extends Mailable
{
    use Queueable, SerializesModels;

    private $item;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->item = $item;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Berlangganan di NusaBelajar')->markdown('pages.homepage.email_subscription.mail', [
            'item' => $this->item,
        ]);
    }
}
