<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactEmail;
use App\Mail\ContactMessage;
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

        Mail::to(config('blog.mail'))
            ->send(new ContactMessage($request));

        flash()->overlay(trans('page.msg_send'), trans('page.great'));


        return back();
    }
}
