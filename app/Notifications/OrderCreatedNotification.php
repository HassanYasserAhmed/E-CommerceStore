<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];

        // $channels = [];
        // if($notifiable->notification_prefernces['order_created']['sms']) {
        //     $channels = ['voyage'];
        // }
        //  if($notifiable->notification_prefernces['order_created']['email']) {
        //     $channels = ['email'];
        // }
        //  if($notifiable->notification_prefernces['order_created']['broadcast']) {
        //     $channels = ['broadcast'];
        // }
        // return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $addr = $this->order->billingAddress;

        return (new MailMessage)
            ->subject("New Order #{$this->order->number}")
            ->greeting("Hi,{$notifiable->name},")
            ->line("new order ({$this->order->number}) created by {$addr->name} from {$addr->countryName}")
            ->action('View Order', url('/dashboard'))
            ->salutation('custom salutation by me')
            ->line('Thank you for using our application!');
    }

    public function toBroadcast($notifiable)
    {

        $addr = $this->order->billingAddress;

        return [
            'body' => "new order ({$this->order->number}) created by {$addr->name} from {$addr->countryName}",
            'icon' => 'fas fa-file',
            'url' => url('/dashboard'),
        ];
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

    public function toDatabase($notifiable)
    {
        $addr = $this->order->billingAddress;

        return [
            'body' => "new order ({$this->order->number}) created by {$addr->name} from {$addr->countryName}",
            'icon' => 'fas fa-file',
            'url' => url('/dashboard'),
        ];
    }
}
