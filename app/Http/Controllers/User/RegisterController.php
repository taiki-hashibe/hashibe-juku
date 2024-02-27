<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function guidance()
    {
        /** @var \App\Models\User $user */
        $user = auth('users')->user();
        if ($user->subscribed('online-salon')) {
            return redirect()->route('user.home');
        }
        $intent = $user->createSetupIntent();

        $stripe = new \Stripe\StripeClient([
            "api_key" => config('stripe.secret'),
            "stripe_version" => "2020-08-27"
        ]);
        $price = $stripe->prices->retrieve(config('stripe.price'));

        $user = auth('users')->user();
        return view('pages.user.register.guidance', [
            'user' => $user,
            'intent' => $intent,
            'price' => $price,
        ]);
    }

    public function register()
    {
        /** @var \App\Models\user $user */
        $user = auth()->user();
        \Stripe\Stripe::setApiKey(config('stripe.secret'));
        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod(request()->payment_method);
        $user->newSubscription('online-salon', config('stripe.price'))->create(request()->payment_method);
        $user->save();
        return redirect()->route('user.home');
    }
}
