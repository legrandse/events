<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;

class OwnerUser extends Pivot
{
    protected $table = 'owner_user';
    protected $fillable = ['owner_id', 'user_id'];
    
    
}
