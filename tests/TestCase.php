<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Subscription;
use Laravel\Cashier\SubscriptionItem;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public User $subscribedUser;

    public function setUp(): void
    {
        parent::setUp();
        if (!User::where('name', 'subscribedUser')->exists()) {
            // User::createではstripe_idがnullになるので、DB::table('users')->insertを使う
            DB::table('users')->insert([
                'name' => 'subscribedUser',
                'line_id' => 'subscribedUser',
                'stripe_id' => env('TEST_USER_STRIPE_CUSTOMER_ID'),
                'pm_type' => 'visa',
            ]);
            $this->subscribedUser = User::where('name', 'subscribedUser')->first();
            Subscription::create([
                'user_id' => $this->subscribedUser->id,
                'type' => 'online-salon',
                'stripe_id' => env('TEST_USER_STRIPE_SUBSCRIPTION_ID'),
                'stripe_status' => 'active',
                'stripe_price' => env('TEST_USER_STRIPE_PRICE_ID'),
                'quantity' => 1,
            ]);
            SubscriptionItem::create([
                'subscription_id' => $this->subscribedUser->id,
                'stripe_id' => env('TEST_USER_STRIPE_SUBSCRIPTION_ITEM_ID'),
                'stripe_product' => env('TEST_STRIPE_PRODUCT_ID'),
                'stripe_price' => env('TEST_STRIPE_PRICE_ID'),
                'quantity' => 1,
            ]);
        }
    }
}
