<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class job_application extends Model
{
    use HasFactory, HasUuids,  SoftDeletes , Notifiable;

    protected $table = "job_applications";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        'status',
        'aiGeneratedScore',
        'aiGeneratedFeedback',
        // relationships
        'userID',
        'resumeID',
        'jobVacancyID'
    ];

    public function Owner()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }

    public function resume()
    {
        return $this->belongsTo(resume::class, 'resumeID', 'id');
    }

    public function JobVacancy()
    {
        return $this->belongsTo(job_vacancy::class, 'jobVacancyID', 'id');
    }
}
