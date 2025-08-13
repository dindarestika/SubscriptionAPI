<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['website_id', 'title', 'description', 'published_at'];

    protected $casts = [ 'published_at' => 'datetime' ];

    public function website() { return $this->belongsTo(Website::class); }
    public function notifications() { return $this->hasMany(PostNotification::class); }
}
