<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DutyCountUpdated extends Notification
{
    use Queueable;

    protected $newDutyCount;
    protected $cadetName;

    /**
     * Create a new notification instance.
     */
    public function __construct($newDutyCount, $cadetName)
    {
        $this->newDutyCount = $newDutyCount;
        $this->cadetName = $cadetName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Duty Count Updated',
            'message' => 'Your duty count has been updated to ' . $this->newDutyCount . ' ' . ($this->newDutyCount == 1 ? 'day' : 'days') . '.',
            'type' => 'duty_update',
            'duty_count' => $this->newDutyCount,
            'icon' => 'shield',
            'url' => route('cadet.dashboard')
        ];
    }
}
