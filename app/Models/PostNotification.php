<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostNotification extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'status', 'sent_at', 'attempts'];

    protected $casts = [ 'sent_at' => 'datetime' ];

    public function post() { return $this->belongsTo(Post::class); }
    public function user() { return $this->belongsTo(User::class); }
}
