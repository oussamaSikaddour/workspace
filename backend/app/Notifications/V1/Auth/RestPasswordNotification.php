<?php

namespace App\Notifications\V1\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Otp;

class RestPasswordNotification extends Notification
{
    use Queueable;
    public $message;
    public $subject;
    public $fromEmail;
    public $mailer;
    private $otp;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->message = "Utilisez le code ci-dessous pour réinitialiser votre mot de passe ";
        $this->subject = "Réinitialisation du mot de passe ";
        $this->fromEmail = "hello@example.com";
        $this->mailer = "smtp";
        $this->otp = new Otp;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $otp = $this->otp->generate($notifiable->email, 6, 60);
        return (new MailMessage)
            ->mailer("smtp")
            ->subject($this->subject)
            ->greeting("bienvenue " . $notifiable->name)
            ->line($this->message)
            ->line("code: " . $otp->token);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
