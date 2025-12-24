<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class job_vacancy extends Model
{
    use HasFactory , HasUuids ,  SoftDeletes;
    protected $table = "job_vacancies";
    protected $keyType = "string";
    public $incrementing = false;

    protected $fillable = 
    [
        'title', 'description' , 'location' , 'salary' ,'tybe' , 'views_count' ,
          //forign keys
        'companyID',
        'categoryID'

    ];

    protected $dates = ['deleted_at'];


    protected function casts(): array
    {
        return [

            'deleted_at' => 'datetime'
        ];
    }

    public function Company()
    {

        return $this->belongsTo(company::class ,'companyID','id');
    }

    public function job_category()
    {
        return $this->belongsTo(job_category::class,'categoryID','id');;
    }

    public function job_application()
    {
        return $this->hasMany(job_application::class,'jobvacancyID','id');;
    }


}
