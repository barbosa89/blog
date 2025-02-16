<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Input;
use App\Http\Requests\SubscribeStore;
use Spatie\Newsletter\NewsletterFacade as Newsletter;

class SubscriptionController extends Controller
{
    /**
     * Store a newly created subscriber in MailChimp API.
     *
     * @param  SubscribeStore  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(SubscribeStore $request)
    {
        $email = Input::clean($request->email);

        if (! Newsletter::isSubscribed($email)) {
            Newsletter::subscribePending($email);

            $msg = trans('page.subscription_email') . '. <br><br><strong>' . trans('page.email') . '</strong>: ' . $email . '.';
            flash()->overlay($msg, trans('page.subscription'));
        } else {
            flash()->overlay(trans('page.subscribed_msg'), trans('page.subscribed'));
        }

        return back();
    }

    /**
     * Unsubscribe a subscriptor in MailChimp API.
     *
     * @param  string  $mail
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe($email)
    {
        $email = Input::clean($email);

        if (Newsletter::isSubscribed($email)) {
            Newsletter::unsubscribe($email);

            $msg = trans('page.unsubscribe_msg') . '. <br><br><strong>' . trans('page.email') . '</strong>: ' . $email . '.';
            flash()->overlay($msg, trans('page.unsubscribe'));
        } else {
            flash()->overlay(trans('page.no_subscribed_msg'), trans('page.no_subscribed'));
        }

        return redirect('/');
    }
}
