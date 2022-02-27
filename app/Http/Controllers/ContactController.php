<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactEmail;
use App\Mail\ContactMessage;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Send a email to owner blog.
     *
     * @param  \App\Http\Requests\ContactEmail  $request
     * @return \Illuminate\Http\Response
     */
    public function message(ContactEmail $request)
    {
        Mail::to($request->email)
            ->send(new ContactMessage($request));

        if (Mail::failures()) {
            flash()->overlay(trans('page.msg_fail'), trans('page.sorry'));

            return back();
        }

        Mail::to('contacto@omarbarbosa.com')
            ->send(new ContactMessage($request));

        flash()->overlay(trans('page.msg_send'), trans('page.great'));


        return back();
    }
}
