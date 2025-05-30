<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    public function detail()
    {
        // each user one user_detils
        return $this->hasOne(UserDetail::class);
    }

    public function department()
    {
        // this user belongs to a department
        return $this->belongsTo(Department::class);
    }
}
