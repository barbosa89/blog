<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * The request instance.
     *
     * @var Request
     */
    protected $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Request $message)
    {
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.message')
            ->replyTo($this->message->email)
            ->with([
                'name' => $this->message->name,
                'email' => $this->message->email,
                'phone' => $this->message->phone,
                'msg' => $this->message->message,
            ]);
    }
}
