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

    public function payment()
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

        return view('pages.user.register.payment', [
            'intent' => $intent,
            'price' => $price,
        ]);
    }

    public function register()
    {
        request()->validate([
            'term_confirm' => 'required',
        ]);
        /** @var \App\Models\user $user */
        $user = auth()->user();
        $token = $user->token;
        $trialDates = $user->withdrawal_at ? 0 : $token?->trial_date ?? 30;
        \Stripe\Stripe::setApiKey(config('cashier.stripe_secret_key'));
        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod(request()->payment_method);
        $subscription = $user->newSubscription(config('cashier.session_plan_name'), config('cashier.session_plan_price'));
        if ($trialDates > 0) {
            $subscription->trialDays($trialDates);
        }
        $subscription->add();
        $user->joined = true;
        $user->save();
        return redirect()->route('home');
    }
}
