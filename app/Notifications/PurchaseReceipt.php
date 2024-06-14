<?php

namespace App\Notifications;

use App\Models\Purchase;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;

class PurchaseReceipt extends Notification
{
    use Queueable;

    protected $path;
    public $id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Purchase $purchase)
    {
        $this->path = $purchase->receipt_pdf_filename;
        $this->id = $purchase->id;
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
        $url = route('purchases.show', $this->id);
        $path = storage_path('app/'.$this->path);
        return (new MailMessage)
            ->from('noreply@cinemagic.com', 'Cinemagic')
            ->subject('Cinemagic - Purchase Receipt')
            ->greeting('Hello!')
            ->line('One of your purchases has been paid!')
            ->line('It is available online')
            ->action('View Receipt', $url)
            ->line('The file is also available as an ' .
                'attachment in this email')
            ->salutation('Thank you for choosing Cinemagic!')
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
