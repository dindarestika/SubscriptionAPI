<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request, Website $website)
    {
        $data = $request->validate([
            'email' => ['required', 'email:rfc,dns'],
            'name'  => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::firstOrCreate(
            ['email' => strtolower($data['email'])],
            ['name' => $data['name'] ?? null]
        );

        $subscription = Subscription::firstOrCreate([
            'user_id' => $user->id,
            'website_id' => $website->id,
        ]);

        return response()->json([
            'message' => 'Subscribed successfully.',
            'data' => [
                'subscription_id' => $subscription->id,
                'website_id' => $website->id,
                'user_id' => $user->id,
            ],
        ], 201);
    }
}
