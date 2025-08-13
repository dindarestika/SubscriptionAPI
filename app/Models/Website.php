<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Website extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'url'];

    public function posts() { return $this->hasMany(Post::class); }
    public function subscriptions() { return $this->hasMany(Subscription::class); }
    public function users() { return $this->belongsToMany(User::class, 'subscriptions'); }

    public static function bySlug(string $slug): ?self
    {
        return Cache::remember("website:{$slug}", 60, fn() => self::where('slug', $slug)->first());
    }
}
