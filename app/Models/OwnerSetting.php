<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwnerSetting extends Model
{
    protected $table = 'owner_settings'; // nom explicite de la table

    protected $fillable = [
        'owner_id',
        'setting_id',
        'value',
    ];
    
    /**
     * Relation vers Owner
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Relation vers Setting
     */
    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

}
