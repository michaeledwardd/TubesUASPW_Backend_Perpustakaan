<?php

namespace App\Notification;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class Email extends VerifyEmailBase
{
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verificationapi.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $notifiable->getKey()]
        );
    }
}
?>