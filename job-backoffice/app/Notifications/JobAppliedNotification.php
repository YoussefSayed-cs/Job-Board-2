<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class JobAppliedNotification extends Notification
{
    use Queueable;

    public $job_application;

    /**
     * Create a new notification instance.
     */
    public function __construct($job_application)
    {


        $this->job_application = $job_application;
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
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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

    public function toDatabase(object $notifiable)
    {
        return [
            'type' => 'job_applied',
            'message' => 'New applicant for your job: '
                . $this->job_application->job->title,
            'job_id' => $this->job_application->job_id,
            'user_id' => $this->job_application->user_id,
        ];
    }
}
