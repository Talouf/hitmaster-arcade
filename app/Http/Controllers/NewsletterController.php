<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscriptions,email',
        ]);

        $subscription = new NewsletterSubscription([
            'email' => $request->email,
            'subscription_date' => now(),
            'is_active' => true,
        ]);

        if (Auth::check()) {
            $subscription->user_id = Auth::id();
        }

        $subscription->save();

        return redirect()->back()->with('newsletter_success', 'Merci de vous être abonné à notre newsletter!');
    }

    public function unsubscribe($token)
    {
        $subscription = NewsletterSubscription::where('token', $token)->firstOrFail();
        $subscription->is_active = false;
        $subscription->save();

        return redirect()->route('home')->with('message', 'Vous avez été désinscrit de la newsletter.');
    }

    public function sendNewsletter(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'content' => 'required|string',
        ]);

        $activeSubscribers = NewsletterSubscription::where('is_active', true)->get();

        foreach ($activeSubscribers as $subscriber) {
            Mail::raw($request->content, function ($message) use ($subscriber, $request) {
                $message->to($subscriber->email)
                    ->subject($request->subject);
            });
        }

        return redirect()->back()->with('message', 'Newsletter envoyée avec succès.');
    }

    public function toggleSubscription(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->newsletterSubscription ?? NewsletterSubscription::where('email', $user->email)->first();

        if ($subscription) {
            $subscription->is_active = !$subscription->is_active;
            $subscription->user_id = $user->id;
            $subscription->save();

            $message = $subscription->is_active
                ? 'Vous êtes maintenant abonné à la newsletter.'
                : 'Vous êtes maintenant désabonné de la newsletter.';
        } else {
            $subscription = NewsletterSubscription::create([
                'user_id' => $user->id,
                'email' => $user->email,
                'subscription_date' => now(),
                'is_active' => true,
            ]);
            $message = 'Vous êtes maintenant abonné à la newsletter.';
        }

        return redirect()->back()->with('status', $message);
    }
}