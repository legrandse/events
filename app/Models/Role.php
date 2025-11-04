<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Role extends SpatieRole
{
    use HasFactory;
    
    /**

     * Scope a query to retreive Admin.

     */

    public function scopeIsAdmin(Builder $query, $teamId)
    {
        return	$query->where('name', 'Admin')
			    ->where('guard_name', 'web')
			    ->where('team_id', $teamId);
    }
    
    
    
}
