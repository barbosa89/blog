<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeStore;
use Illuminate\Http\RedirectResponse;
use Spatie\Newsletter\Facades\Newsletter;

class SubscriptionController extends Controller
{
    public function subscribe(SubscribeStore $request): RedirectResponse
    {
        $email = $request->email;

        if (! Newsletter::isSubscribed($email)) {
            Newsletter::subscribePending($email);

            $msg = trans('page.subscription_email') . '. <br><br><strong>' . trans('page.email') . '</strong>: ' . $email . '.';
            flash()->overlay($msg, trans('page.subscription'));
        } else {
            flash()->overlay(trans('page.subscribed_msg'), trans('page.subscribed'));
        }

        return back();
    }

    public function unsubscribe(string $email): RedirectResponse
    {
        if (Newsletter::isSubscribed($email)) {
            Newsletter::unsubscribe($email);

            $msg = trans('page.unsubscribe_msg') . '. <br><br><strong>' . trans('page.email') . '</strong>: ' . e($email) . '.';

            flash()->overlay($msg, trans('page.unsubscribe'));
        } else {
            flash()->overlay(trans('page.no_subscribed_msg'), trans('page.no_subscribed'));
        }

        return redirect('/');
    }
}
