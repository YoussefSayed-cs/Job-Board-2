<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class resume extends Model
{
    use HasFactory , HasUuids , SoftDeletes;
    protected $table = "resumes";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = 
    [
        'filename', 'fileUri' , 'contactDetails' , 'education' , 'summary' , 'skills' , 'experience' ,
        //foreign key
        'userID'


    ];

    protected $dates = ['deleted_at'];


    protected function casts(): array
    {
        return [

            'deleted_at' => 'datetime'
        ];
    }


     public function User()
    {
        return $this->belongsTo(User::class ,'userID' ,'id');
    }
    
    public function job_applaction()
    {
        return $this->hasMany(job_application::class,'userID','id');;
    }


}
