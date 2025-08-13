<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Website;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request, Website $website)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $post = Post::create([
            'website_id' => $website->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'published_at' => now(),
        ]);

        return response()->json([
            'message' => 'Post created.',
            'data' => $post,
        ], 201);
    }
}
