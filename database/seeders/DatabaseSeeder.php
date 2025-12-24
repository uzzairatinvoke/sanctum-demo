<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // senaraikan semua permissions yang kita nak ada dalam sistem
        $permissions = [
            'view-documents',
            'create-documents',
            'edit-documents',
            'delete-documents',
        ];

        // create semua permissions
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        $roles = [
            'admin',
            'manager',
            'employee'
        ];

        // create semua roles
        foreach ($roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }

        // admin boleh buat semua actions documents
        // manager boleh read dan edit semua documents
        // employee boleh read semua documents

        $adminRole = Role::where('name', 'admin')->first();
        // bagi superadmin role semua permissions
        $adminRole->givePermissionTo(Permission::all());

        $managerRole = Role::where('name', 'manager')->first();
        $managerRole->givePermissionTo([
            'view-documents',
            'create-documents'
        ]);
        $employeeRole = Role::where('name', 'employee')->first();
        $employeeRole->givePermissionTo([
            'view-documents'
        ]);

        // create admin
        $admin = User::factory()
            ->state([
                'name' => 'Admin',
                'email' => 'admin@mail.com',
            ])
            ->hasDocuments(4)
            ->create();
        $admin->assignRole($adminRole);

        // create manager
        $manager = User::factory()
            ->state([
                'name' => 'Manager',
                'email' => 'manager@mail.com',
            ])
            ->hasDocuments(4)
            ->create();
        $manager->assignRole($managerRole);
        // create employee
        $employee = User::factory()
            ->state([
                'name' => 'Employee',
                'email' => 'employee@mail.com',
            ])
            ->hasDocuments(4)
            ->create();
        $employee->assignRole($employeeRole);
    }
}
