<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run()
    {
        // Define roles
        $roles = [
            'admin',
            'editor',
            'author',
            'user',
        ];

        // Create roles in the database
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]); // Create the role if it doesn't exist
        }

        // Define permissions
        $permissions = [
            'create articles',
            'edit articles',
            'delete articles',
            'publish articles',
            'unpublish articles',
            'view articles',
            'manage users',
            'manage roles',
            'manage permissions',
        ];

        // Create permissions in the database
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]); // Create the permission if it doesn't exist
        }

        // Assign permissions to roles
        $rolePermissions = [
            'admin' => $permissions, // Admin has all permissions
            'editor' => [
                'create articles',
                'edit articles',
                'publish articles',
                'unpublish articles',
                'view articles',
            ],
            'author' => [
                'create articles',
                'edit articles',
                'publish articles',
                'view articles',
            ],
            'user' => [
                'view articles',
            ],
        ];

        // Assign permissions to each role
        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::findByName($roleName); // Find the role by name
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission); // Assign permissions to the role
            }
        }

        // Create a persistent admin user
        $adminEmail = 'admin@example.com'; // Choose the admin email
        $adminPassword = 'password'; // Choose a password

        // Use firstOrCreate to ensure the admin user is created if it doesn't already exist
        $adminUser = User::firstOrCreate(
            ['email' => $adminEmail], // Check for existing user with this email
            [
                'first_name' => 'Admin', // Default name for the admin user
                'password' => Hash::make($adminPassword), // Ensure the password is hashed for security
            ]
        );

        // Assign the 'admin' role to the admin user
        $adminUser->assignRole('admin');
    }
}
