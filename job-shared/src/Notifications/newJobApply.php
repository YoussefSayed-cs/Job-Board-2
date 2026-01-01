<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class newJobApply extends Notification
{
    use Queueable;

    private $job_seeker;
    private $job;
    private $jobApplication;

    private $applicationID;




    public function __construct($job_seeker, $job, $jobApplication, $applicationID)
    {
        $this->job_seeker = $job_seeker;
        $this->job = $job;
        $this->jobApplication = $jobApplication;
        $this->applicationID = $applicationID;
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
            'job_seeker_id' => $this->job_seeker->id,
            'job_seeker_name' => $this->job_seeker->name,
            'job_id' => $this->job->id,
            'job_title' => $this->job->title,
            'application_id' => $this->applicationID,
            'created_at' => now(),
            
        ];
    }
}
