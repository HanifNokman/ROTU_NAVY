<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AbsenceJustificationRequired extends Notification
{
    use Queueable;

    protected $trainingTitle;
    protected $trainingDate;
    protected $missingItems;

    /**
     * Create a new notification instance.
     */
    public function __construct($trainingTitle, $trainingDate, $missingItems = [])
    {
        $this->trainingTitle = $trainingTitle;
        $this->trainingDate = $trainingDate;
        $this->missingItems = $missingItems;
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
        $missingItemsText = implode(', ', $this->missingItems);

        return [
            'title' => 'Absence Justification Required',
            'message' => 'Please provide ' . $missingItemsText . ' for your absence from "' . $this->trainingTitle . '" on ' . $this->trainingDate . '.',
            'type' => 'absence_justification',
            'training_title' => $this->trainingTitle,
            'training_date' => $this->trainingDate,
            'missing_items' => $this->missingItems,
            'icon' => 'alert',
            'url' => route('cadet.attendance')
        ];
    }
}
