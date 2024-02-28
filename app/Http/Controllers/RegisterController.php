<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function guidance()
    {
        if (auth('users')->check()) {
            return redirect()->route('user.' . request()->route()->getName());
        }
        $stripe = new \Stripe\StripeClient([
            "api_key" => config('stripe.secret'),
            "stripe_version" => "2020-08-27"
        ]);
        $price = $stripe->prices->retrieve(config('stripe.price'));

        return view('pages.user.register.guidance', [
            'price' => $price,
        ]);
    }
}
