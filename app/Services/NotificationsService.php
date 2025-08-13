<?php

namespace App\Services;

use App\Contracts\NotificationsServiceInterface;
use App\Jobs\SendPostNotificationJob;
use App\Models\Post;
use App\Models\PostNotification;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostNotificationMail;
use App\Models\User;
use Carbon\Carbon;

class NotificationsService implements NotificationsServiceInterface
{
    public function dispatchForPost(Post $post): int
    {
        $jobCount = 0;

        $users = User::where('id', '!=', $post->user_id)->get();

        foreach ($users as $user) {
            $notification = PostNotification::updateOrCreate(
                [
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                ],
                [
                    'message' => 'New post: ' . $post->title,
                    'status' => 'pending', // default pending
                    'is_read' => false,
                ]
            );

            if ($notification->status === 'pending') {
                SendPostNotificationJob::dispatch($post, $user);
                $jobCount++;
            }
        }

        return $jobCount;
    }
}
