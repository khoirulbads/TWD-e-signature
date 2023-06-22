<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;

class SubmissionsModel extends Model
{
    use HasFactory;
    use SoftDeletes; 

    public $incrementing = false; 
    protected $table = 'submissions'; 

    public function documents()
    {
        return $this->hasMany('App\Models\DocumentsModel', 'submission_id', 'id');
    }
}
