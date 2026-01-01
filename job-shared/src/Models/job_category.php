<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;



class job_category extends Model
{
    use HasFactory , HasUuids ,  SoftDeletes , Notifiable;
    protected $table = "job_categories";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = 
    [
        'name', 
    ];

    protected $dates = ['deleted_at'];


    protected function casts(): array
    {
        return [

            'deleted_at' => 'datetime'
        ];
    }

    public function job_vacancies()
    {
        return $this->hasMany(job_vacancy::class ,'catagoryID','id');
    }


}
