<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationsModel extends Model
{
    use HasFactory;
    use SoftDeletes; 

    public $incrementing = false; 
    protected $table = 'notification'; 

    public function submission()
    {
        return $this->hasOne('App\Models\SubmissionsModel', 'submission_id', 'id');
    }
    
    public function from()
    {
        return $this->hasOne('App\Models\User', 'unique_id', 'signee_id');
    }
}
