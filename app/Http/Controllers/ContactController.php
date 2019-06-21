<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Http\Request;
use App\Mail\ContactMessage;
use App\Http\Requests\ContactEmail;

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
        Mail::to('contacto@omarbarbosa.com')
            ->send(new ContactMessage($request));

        if (Mail::failures()) {
            flash()->overlay(trans('page.msg_fail'), trans('page.sorry'));
        } else {
            flash()->overlay(trans('page.msg_send'), trans('page.great'));
        }

        return back();
    }
}