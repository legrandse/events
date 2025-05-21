<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;
    
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'start',
        'submited',
        'location',
        'attendee',
        
    ];
    
        protected $casts = [
        'attendee' => 'array',
    ];
    
    
    /**
     * Get the tasks for the event.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function shifts(): HasMany
    {
        return $this->hasMany(Shift::class);
    }
    
    public function setStartAttribute( $value ) {
	  $this->attributes['start'] = (new Carbon($value))->format('Y-m-d');
	  
	}
	/*public function setDepartureAttribute( $value ) {
	  $this->attributes['departure'] = (new Carbon($value))->format('Y-m-d');
	  
	}*/
}
