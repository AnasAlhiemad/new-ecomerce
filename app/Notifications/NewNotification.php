<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Http\Controllers\OrderController;

class NewNotification extends Notification
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
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */

    public function toMail($notifiable)//: MailMessage
    {
        // $data11=new OrderController();
        // $data= $data11->addOrder()->$data1;
       // $value = $this->orderController->$data1;
         return (new MailMessage)
                    ->subject('Online Store')
                    ->line($this->content)
                    ->line('Is product available pleas communicate with him as soon as possible?')
                    //->action('not confirmation', url('/'))
                    //->action('not', url('/'))
                     ->line('if  product not available')
                    ->action(' not Confirm Order', url([OrderController::class,'addOrder']))
                    //->action('Cancel Order', url('order.cancel', ['orderId' => $this->orderId]))
                    ->line('if not available')
                    //->action('not confirmation', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Notification',
            'body' => 'This is a new notification.',
            'action_url' => url('/'),
        ];
    }
}
