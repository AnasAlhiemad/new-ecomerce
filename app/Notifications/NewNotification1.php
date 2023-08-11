<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewNotification1 extends Notification
{
    use Queueable;
    protected $content;

    /**
     * Create a new notification instance.
     */
    public function __construct($content)
    {
        $this->content =$content;
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
                    ->subject('Online Store')
                    ->line($this->content)
                    ->line('if product is available,the owner will contact as soon as possible')
                   // ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }


    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
