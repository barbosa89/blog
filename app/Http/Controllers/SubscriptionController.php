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

            flash(trans('page.subscription_email') . '. <br><br><strong>' . trans('page.email') . '</strong>: ' . $email . '.')->success();
        } else {
            flash(trans('page.subscribed_msg'))->success();
        }

        return back();
    }

    public function unsubscribe(string $email): RedirectResponse
    {
        if (Newsletter::isSubscribed($email)) {
            Newsletter::unsubscribe($email);

            flash(trans('page.unsubscribe_msg') . '. <br><br><strong>' . trans('page.email') . '</strong>: ' . e($email) . '.')->success();
        } else {
            flash(trans('page.no_subscribed_msg'))->error();
        }

        return redirect('/');
    }
}
