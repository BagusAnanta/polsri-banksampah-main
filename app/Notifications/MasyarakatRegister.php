<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MasyarakatRegister extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public $masyarakatdata)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                'title' => "Data masyarakat perlu divalidasi",
                'message' => 'Data masyarakat baru masuk, perlu divalidasi',
                'reference_id' => $this->masyarakatdata->masyarakat_id,
                'type' => "setoran_sampah_{$this->masyarakatdata->verification}",
        ];
    }
}
