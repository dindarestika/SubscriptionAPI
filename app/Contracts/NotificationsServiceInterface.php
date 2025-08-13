<?php

namespace App\Contracts;

use App\Models\Post;

interface NotificationsServiceInterface
{
    public function dispatchForPost(Post $post): int; // returns job count
}
