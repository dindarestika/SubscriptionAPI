<?php

namespace Database\Seeders;

use App\Models\Website;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WebsiteSeeder extends Seeder
{
    public function run(): void
    {
        $sites = [
            ['name' => 'Tech Daily', 'url' => 'https://techdaily.example'],
            ['name' => 'Food Lovers', 'url' => 'https://foodlovers.example'],
        ];

        foreach ($sites as $s) {
            Website::firstOrCreate(
                ['slug' => Str::slug($s['name'])],
                ['name' => $s['name'], 'url' => $s['url']]
            );
        }
    }
}
