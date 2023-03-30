<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailVerificationNotification extends \Illuminate\Auth\Listeners\SendEmailVerificationNotification implements ShouldQueue
{
    use Queueable;
}