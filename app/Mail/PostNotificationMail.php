<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public function build()
    {
        return $this->subject('New Post Notification')
            ->view('emails.post_notification')
            ->with([
                'post' => $this->post
            ]);
    }
}
