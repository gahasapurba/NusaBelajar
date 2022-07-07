<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DiscussionAnswer extends Mailable
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
        return $this->subject('Jawaban Baru Pada Diskusi')->markdown('pages.admin.discussion_answer.mail', [
            'item' => $this->item,
        ]);
    }
}
