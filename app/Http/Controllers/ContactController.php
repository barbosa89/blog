<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use App\Http\Requests\ContactEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function message(ContactEmail $request): RedirectResponse
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
