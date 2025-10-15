<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'organisation',
        'shortname',
        'address',
        'postcode',
        'place',
        'vat',
        'product_id',
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
    
    public function product()
	{
	    return $this->belongsTo(Price::class, 'product_id');
	}
	
	/*public function users()
	{
	    return $this->belongsToMany(User::class, 'owner_user', 'owner_id', 'user_id')
	                ->using(OwnerUser::class)
	                ->withTimestamps();
	}*/
	public function users()
	{
	    return $this->belongsToMany(User::class, 'owner_user', 'owner_id', 'user_id')
	                ->using(OwnerUser::class) // facultatif
	                ->withTimestamps();
	}

}
