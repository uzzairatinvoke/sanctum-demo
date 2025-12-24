<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        /** Admin */
        
        // cari user pertama
        $adminUser = User::where('email','admin@mail.com')->first();
        // assign role superadmin pada user pertama
        $adminUser->assignRole($adminRole);

        /** Manager */
        $managerRole = Role::where('name','manager')->first();
        $managerRole->givePermissionTo([
            'view-documents','create-documents'
        ]);
        $managerUser = User::where('email','manager@mail.com')->first();
        $managerUser->assignRole($managerRole);

        /** Employee */
        $employeeRole = Role::where('name','employee')->first();
        $employeeRole->givePermissionTo([
            'view-documents'
        ]);
        $employeeUser = User::where('email','employee@mail.com')->first();
        $employeeUser->assignRole($employeeRole);

    }
}
