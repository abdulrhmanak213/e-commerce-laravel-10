<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{

    public function run()
    {
        $role = Role::create(['name' => 'admin','guard_name'=>'user'])->save();
        $role = Role::create(['name' => 'user','guard_name'=>'user'])->save();
    }
}
