<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;

class PurchaseReceipt extends Notification
{
    use Queueable;

    protected $path;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
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
        $url = url('/invoice/' . $this->invoice->id);
        $path = storage_path('app/'.$this->invoice->fileName);
        return (new MailMessage)
            ->greeting('Hello!')
            ->line('One of your purchases has been paid!')
            ->line('It is available online')
            ->action('View Receipt', $url)
            ->line('The file is also available as an ' .
                'attachment in this email')
            ->line('Thank you for using Cinemagic!')
            ->attach($path);
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
