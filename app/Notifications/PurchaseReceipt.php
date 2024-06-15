<?php

namespace App\Notifications;

use App\Models\Purchase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PurchaseReceipt extends Notification
{
    use Queueable;

    protected $path;
    public $id;
    private Purchase $purchase;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Purchase $purchase)
    {
        $this->path = $purchase->receipt_pdf_filename;
        $this->id = $purchase->id;
        $this->purchase = $purchase;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = route('purchases.show', $this->id);
        $path = storage_path('app/' . $this->path);
        $email = new MailMessage();

        $email->from('noreply@cinemagic.com', 'Cinemagic')
            ->subject('Cinemagic - Purchase Receipt and Tickets')
            ->greeting('Hello!')
            ->line('One of your purchases has been paid!')
            ->line('It is available online')
            ->action('View Receipt', $url)
            ->line('The receipt and your tickets are attached to this email.')
            ->salutation('Thank you for choosing Cinemagic!');

        foreach ($this->purchase->tickets as $index => $ticket) {
            $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($ticket->qrcode_url));
            $pdf = Pdf::loadView('tickets.print', [
                'ticket' => $ticket,
                'qrcode' => $qrcode
            ]);
            $pdfticket = $pdf->output();
            $email->attachData($pdfticket, 'ticket_' . $ticket->obfuscatedId . '.pdf', [
                'mime' => 'application/pdf',
            ]);
        }
        $email->attach($path);

        return $email;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
