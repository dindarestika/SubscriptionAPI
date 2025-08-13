<?php

namespace App\Console\Commands;

use App\Contracts\NotificationsServiceInterface;
use App\Models\Post;
use Illuminate\Console\Command;

class DispatchPostNotifications extends Command
{
    protected $signature = 'posts:dispatch-notifications {--postId=}';
    protected $description = 'Scan for new posts and dispatch notifications to subscribers.';

    public function handle(NotificationsServiceInterface $service): int
    {
        $postId = $this->option('postId');

        $query = Post::query()->with('website')
            ->whereNotNull('published_at')
            ->whereDoesntHave('notifications', function ($q) {
                $q->where('status', 'sent');
            });

        if ($postId) {
            $query->where('id', $postId);
        }

        $totalJobs = 0;
        $query->orderBy('id')->chunk(200, function ($posts) use ($service, &$totalJobs) {
            foreach ($posts as $post) {
                $jobs = $service->dispatchForPost($post);
                $this->info("Post #{$post->id} → dispatched {$jobs} jobs.");
                $totalJobs += $jobs;
            }
        });

        $this->info("Total jobs dispatched: {$totalJobs}");
        return self::SUCCESS;
    }
}
