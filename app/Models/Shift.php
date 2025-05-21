<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class Shift extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        
        'start',
        'end',
        'user_id',
        'event_id',
        'task_id',
        'is_confirmed',
        'is_sent',
        
    ];
    
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
   
    
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    
}
