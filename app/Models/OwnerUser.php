<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerUser extends Model
{
    protected $table = 'owner_user';
    protected $fillable = ['owner_id', 'user_id', 'role', 'status'];
}
