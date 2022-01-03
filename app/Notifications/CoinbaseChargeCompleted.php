<?php

namespace App\Notifications;

use CoinbaseCommerce\Resources\Charge;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;
use Laravel\Cashier\Subscription;

class CoinbaseChargeCompleted extends Notification
{
    private $charge;
    private $subscription;

    /**
     * Create a new notification instance.
     *
     * @param Charge $charge
     * @param Subscription $subscription
     */
    public function __construct(Charge $charge, Subscription $subscription)
    {
        $this->charge = $charge;
        $this->subscription = $subscription;
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
        $endsAt = $this->subscription->cancelled()
            ? $this->subscription->ends_at
            : now()->addMonth();

        return (new MailMessage)
            ->subject('Payment status updated #'.$this->charge['code'])
                    ->line(new HtmlString('The crypto payment with code <strong>'.$this->charge['code'].'</strong> has been successfully processed.'))
                    ->line('The purchased subscription has been added to your account.')
                    ->action('View profile', route('profile'))
                    ->line(new HtmlString('You are now subscribed until <strong>'.$endsAt.'</strong>.'));
    }
}
