<?php

namespace App\Notifications\V1;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserPasswordNotification extends Notification
{
    use Queueable;
    public $message;
    public $subject;
    public $fromEmail;
    public $mailer;
    public $password;

    /**
     * Create a new notification instance.
     */
    public function __construct(String $password)
    {
        $this->message = "utilisez ce mot de passe pour la première connexion et changez-le";
        $this->subject = "première connexion";
        $this->fromEmail = "hello@example.com";
        $this->mailer = "smtp";
        $this->password = $password;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        return (new MailMessage)
            ->mailer("smtp")
            ->subject($this->subject)
            ->greeting("bienvenue " . $notifiable->name)
            ->line($this->message)
            ->line("ton mot de pass: " . $this->password);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
