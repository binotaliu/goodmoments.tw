<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class PasswordSetupNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly User $user,
    ) {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('請立即設定密碼')
            ->line('您的帳號已經建立，')
            ->line('請前往下列連結設定您的密碼。')
            ->action('設定密碼', URL::temporarySignedRoute('admin.setup-password', now()->addHours(24), ['email' => $this->user->email]));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
