<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // define roles and permissions

        $permissions = [
            'create-documents',
            'view-documents',
            'edit-documents',
            'delete-documents'
        ];

        $roles = [
            'admin',
            'manager',
            'employee'
        ];

        // populate the roles and permissions in the database
        foreach ($permissions as $permission) {
            // create permission
            Permission::create([
                'name' => $permission
            ]);
        }

        foreach ($roles as $role) {
            // create role
            Role::create([
                'name' => $role
            ]);
        }

        // assigning permissios to Admin
        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo(Permission::all());

        // assigning permissions to Manager
        $managerRole = Role::where('name', 'manager')->first();
        $managerRole->givePermissionTo([
            'create-documents',
            'view-documents',
            'edit-documents'
        ]);

        // assigning permissions to Employee
        $employeeRole = Role::where('name', 'employee')->first();
        $employeeRole->givePermissionTo([
            'view-documents'
        ]);

        // create admin user
        $admin = User::factory()->state([
            'name' => 'Admin',
            'email' => 'admin@mail.com'
        ])
            ->hasDocuments(5)
            ->create();

        $admin->assignRole('admin');


        // create manager user

        $manager = User::factory()->state([
            'name' => 'Manager',
            'email' => 'manager@mail.com'
        ])
            ->hasDocuments(5)
            ->create();

        $manager->assignRole('manager');


        // create employee user

        $employee = User::factory()->state([
            'name' => 'Employee',
            'email' => 'employee@mail.com'
        ])
            ->hasDocuments(5)
            ->create();

        $employee->assignRole('employee');
    }
}
