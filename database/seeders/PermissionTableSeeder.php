<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Permissions
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'event-list',
            'event-create',
            'event-edit',
            'event-delete',
            'task-list',
            'task-create',
            'task-edit',
            'task-delete',
            'shift-list',
            'shift-create',
            'shift-edit',
            'shift-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
        ];
       
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
