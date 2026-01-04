<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SelectionCompleteNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $intakeYear;

    /**
     * Create a new notification instance.
     */
    public function __construct($intakeYear)
    {
        $this->intakeYear = $intakeYear;
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
            ->subject('PALAPES LAUT UMS Selection Process - Update')
            ->view('emails.selection-complete', [
                'name' => $notifiable->name,
                'email' => $notifiable->email,
                'intakeYear' => $this->intakeYear,
                'statusUrl' => route('application.status'),
            ]);
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
