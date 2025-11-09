<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ContactEmailRequest;
use App\Mail\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function message(ContactEmailRequest $request): RedirectResponse
    {
        try {
            Mail::to($request->email)
                ->send(new ContactMessage($request));

            Mail::to(config('blog.mail'))
                ->send(new ContactMessage($request));

            flash()->overlay(trans('page.msg_send'), trans('page.great'));
        } catch (Throwable $th) {
            report($th);

            flash()->overlay(trans('page.msg_fail'), trans('page.sorry'));
        } finally {
            return back();
        }
    }
}
