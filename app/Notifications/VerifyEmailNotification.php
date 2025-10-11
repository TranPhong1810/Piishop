<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Tạo URL tạm thời để xác nhận email
        $url = URL::temporarySignedRoute(
            'auth.verify-email',
            now()->addMinutes(60),
            ['token' => $this->token]
        );

        // Sử dụng Blade view để gửi email
        return (new MailMessage)
            ->subject('Xác nhận đăng ký')
            ->view('auth.verifyEmail', ['user' => $notifiable, 'url' => $url]);
    }
}
