<?php

namespace App\Jobs;

use App\Models\Post;
use App\Models\User;
use App\Models\PostNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostNotificationMail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPostNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Post $post;
    protected User $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    public function handle(): void
    {
        try {
            Mail::to($this->user->email)->send(new PostNotificationMail($this->post));

            // update status
            PostNotification::where('post_id', $this->post->id)
                ->where('user_id', $this->user->id)
                ->update(['status' => 'sent']);
        } catch (\Exception $e) {
            // log error
            PostNotification::where('post_id', $this->post->id)
                ->where('user_id', $this->user->id)
                ->update(['status' => 'failed']);

            \Log::error("Failed to send post notification: " . $e->getMessage());
        }
    }
}
