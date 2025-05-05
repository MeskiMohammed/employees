<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        $tables = [
            'employees',
            'departments',

            'leaves',
            'freelancer_projects',
            'types',

            'payment_types',
            'operators',
            'statuses',
            'reasons',
        ];
        foreach ($tables as $table) {
            Permission::create(['name' => "view $table"]);
            Permission::create(['name' => "create $table"]);
            Permission::create(['name' => "edit $table"]);
            Permission::create(['name' => "delete $table"]);
        }

        Role::create(['name'=>'employee']);
        Role::create(['name'=>'admin']);
        $role = Role::create(['name'=>'super_admin']);
        $role->syncPermissions(Permission::all());
    }
}
