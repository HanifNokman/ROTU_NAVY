<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Training;

class TrainingDayNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $training;
    protected $userType;

    /**
     * Create a new notification instance.
     */
    public function __construct(Training $training, $userType = 'cadet')
    {
        $this->training = $training;
        $this->userType = $userType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $actionText = $this->userType === 'cadet' ? 'Mark Attendance' : 'View Training Details';
        $actionUrl = $this->userType === 'cadet' ? route('cadet.attendance') : route('instructor.training');

        return (new MailMessage)
            ->subject('Training Today: ' . $this->training->title)
            ->view('emails.training-day', [
                'name' => $notifiable->name,
                'email' => $notifiable->email,
                'training' => $this->training,
                'trainingTime' => $this->training->start_datetime->format('H:i'),
                'actionText' => $actionText,
                'actionUrl' => $actionUrl,
                'userType' => $this->userType,
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
            'title' => 'Training Today',
            'message' => 'Training "' . $this->training->title . '" is happening TODAY at ' . $this->training->start_datetime->format('H:i') . ' at ' . $this->training->location . '. Don\'t forget to mark your attendance!',
            'type' => 'training_day',
            'training_id' => $this->training->id,
            'training_title' => $this->training->title,
            'training_date' => $this->training->start_datetime->format('d/m/Y'),
            'training_time' => $this->training->start_datetime->format('H:i'),
            'training_location' => $this->training->location,
            'icon' => 'calendar',
            'url' => $this->userType === 'cadet' ? route('cadet.attendance') : route('instructor.training')
        ];
    }
}
