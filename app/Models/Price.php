<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    

    protected $fillable = [
        'product',
        'amount',
    ];
    
    public function owners()
	{
	    return $this->hasMany(Owner::class, 'product_id');
	}

    
}