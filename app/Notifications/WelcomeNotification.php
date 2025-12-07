<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $userType;
    protected $temporaryPassword;

    /**
     * Create a new notification instance.
     */
    public function __construct($userType = 'cadet', $temporaryPassword = null)
    {
        $this->userType = $userType;
        $this->temporaryPassword = $temporaryPassword;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $dashboardRoute = match($this->userType) {
            'cadet' => route('cadet.dashboard'),
            'instructor' => route('instructor.dashboard'),
            'admin' => route('admin.dashboard'),
            default => route('login')
        };

        $mail = (new MailMessage)
            ->subject('Welcome to ROTU NAVY UMS - Training System')
            ->greeting('Welcome, ' . $notifiable->name . '!')
            ->line('Your account has been successfully created in the ROTU NAVY UMS - Reserve Officer Training Unit Management System.')
            ->line('You can now access the system to manage your training activities, view schedules, and track your progress.');

        if ($this->temporaryPassword) {
            $mail->line('**Your Login Credentials:**')
                ->line('Email: ' . $notifiable->email)
                ->line('Temporary Password: ' . $this->temporaryPassword)
                ->line('⚠️ **IMPORTANT:** Please change your password immediately after your first login for security purposes.');
        }

        $mail->action('Access Your Dashboard', $dashboardRoute)
            ->line('If you have any questions or need assistance, please contact your administrator.')
            ->line('Thank you for being part of ROTU NAVY!');

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Welcome to ROTU NAVY UMS',
            'message' => 'Your account has been successfully created. You can now access the system and start using all available features.',
            'type' => 'account_created',
            'icon' => 'shield',
            'url' => match($this->userType) {
                'cadet' => route('cadet.dashboard'),
                'instructor' => route('instructor.dashboard'),
                'admin' => route('admin.dashboard'),
                default => route('login')
            }
        ];
    }
}
