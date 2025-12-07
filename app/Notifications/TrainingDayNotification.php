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
        return (new MailMessage)
            ->subject('Training Today: ' . $this->training->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('This is a reminder that you have a training scheduled TODAY.')
            ->line('**Training Details:**')
            ->line('Title: ' . $this->training->title)
            ->line('Time: ' . $this->training->start_datetime->format('h:i A'))
            ->line('Location: ' . $this->training->location)
            ->line('Duration: ' . $this->training->formatted_duration)
            ->action('Mark Attendance', $this->userType === 'cadet' ? route('cadet.attendance') : route('instructor.training'))
            ->line('Please arrive on time and be prepared for the training session.');
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
            'message' => 'Training "' . $this->training->title . '" is happening TODAY at ' . $this->training->start_datetime->format('h:i A') . ' at ' . $this->training->location . '. Don\'t forget to mark your attendance!',
            'type' => 'training_day',
            'training_id' => $this->training->id,
            'training_title' => $this->training->title,
            'training_date' => $this->training->start_datetime->format('M d, Y'),
            'training_time' => $this->training->start_datetime->format('h:i A'),
            'training_location' => $this->training->location,
            'icon' => 'calendar',
            'url' => $this->userType === 'cadet' ? route('cadet.attendance') : route('instructor.training')
        ];
    }
}
