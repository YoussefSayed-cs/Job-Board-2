<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class company extends Model
{
    use HasFactory, HasUuids, Notifiable, SoftDeletes;

    protected $table = "Companies";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = [
        'name',
        'address',
        'industry',
        'description',
        'website',
        'ownerID'
    ];

    protected $dates = ['deleted_at'];

    protected function casts(): array
    {
        return [
            'deleted_at' => 'datetime'
        ];
    }

    public function Owner()
    {
        return $this->belongsTo(User::class, 'ownerID', 'id');
    }

    
    public function jobVacancies()
    {
        return $this->hasMany(job_vacancy::class, 'companyID', 'id');
    }
}
