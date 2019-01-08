<?php

namespace App\Http\Controllers;

use Newsletter;
use App\Helpers\Input;
use Illuminate\Http\Request;
use App\Http\Requests\SubscribeStore;

class SubscriptionController extends Controller
{
    public function subscribe(SubscribeStore $request)
    {
        $email = Input::clean($request->email);

        if (!Newsletter::isSubscribed($email) ) 
        {
            Newsletter::subscribePending($email);

            $msg = trans('page.subscription_email') . '. <br><br><strong>' . trans('page.email') . '</strong>: '. $email . '.';
            flash()->overlay($msg, trans('page.subscription'));
        } else {
            flash()->overlay(trans('page.subscribed_msg'), trans('page.subscribed'));
        }

        return back();
    }
}
