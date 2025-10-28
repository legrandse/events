<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    

    protected $fillable = [
        'name',
        'price',
        'max_events',
        'max_volunteers'
    ];
    
    public function owners()
	{
	    return $this->hasMany(Owner::class, 'product_id');
	}

    
}