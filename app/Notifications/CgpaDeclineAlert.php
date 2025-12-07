<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CgpaDeclineAlert extends Notification
{
    use Queueable;

    protected $cadetName;
    protected $cadetId;
    protected $serviceNumber;
    protected $currentCgpa;
    protected $pastCgpa;
    protected $decline;

    /**
     * Create a new notification instance.
     */
    public function __construct($cadetName, $cadetId, $serviceNumber, $currentCgpa, $pastCgpa, $decline)
    {
        $this->cadetName = $cadetName;
        $this->cadetId = $cadetId;
        $this->serviceNumber = $serviceNumber;
        $this->currentCgpa = $currentCgpa;
        $this->pastCgpa = $pastCgpa;
        $this->decline = $decline;
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
            'title' => 'CGPA Decline Alert',
            'message' => $this->cadetName . ' (' . $this->serviceNumber . ') has experienced a CGPA decline of ' . number_format(abs($this->decline), 2) . ' (from ' . number_format($this->pastCgpa, 2) . ' to ' . number_format($this->currentCgpa, 2) . ').',
            'type' => 'cgpa_decline',
            'cadet_id' => $this->cadetId,
            'cadet_name' => $this->cadetName,
            'service_number' => $this->serviceNumber,
            'current_cgpa' => $this->currentCgpa,
            'past_cgpa' => $this->pastCgpa,
            'decline' => $this->decline,
            'icon' => 'warning',
            'url' => route('instructor.cadet_management') . '?cadet_id=' . $this->cadetId
        ];
    }
}
