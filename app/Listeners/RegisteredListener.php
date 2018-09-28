<?php
declare(strict_types=1);

namespace App\Listeners;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Mail\Mailer;

class RegisteredListener
{
    /**
     * @var \Illuminate\Mail\Mailer
     */
    private $mailer;

    /**
     * @var \App\User
     */
    private $eloquent;

    /**
     * Create the event listener.
     *
     * @param  \Illuminate\Mail\Mailer $mailer
     * @param  \App\User $eloquent
     *
     * @return void
     */
    public function __construct(Mailer $mailer, User $eloquent)
    {
        $this->mailer = $mailer;
        $this->eloquent = $eloquent;
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $user = $this->eloquent->findOrFail($event->user->getAuthIdentifier());

        $this->mailer->raw('会員登録完了しました', function ($message) use ($user) {
            $message->subject('会員登録メール')->to($user->email);
        });
    }
}
