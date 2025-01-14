<?php

namespace Database\Seeders;

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
        Permission::create(['name' => 'create-user',]);
        Permission::create(['name' => 'edit-user',]);
        Permission::create(['name' => 'delete-user',]);
        Permission::create(['name' => 'show-user',]);

        Permission::create(['name' => 'create-text',]);
        Permission::create(['name' => 'edit-text',]);
        Permission::create(['name' => 'delete-text',]);
        Permission::create(['name' => 'show-text',]);

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'penulis']);

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('create-user');
        $roleAdmin->givePermissionTo( 'edit-user');
        $roleAdmin->givePermissionTo('delete-user');
        $roleAdmin->givePermissionTo('show-user');

        $rolePenulis = Role::findByName('penulis');
        $rolePenulis->givePermissionTo('create-text');
        $rolePenulis->givePermissionTo('edit-text');
        $rolePenulis->givePermissionTo('delete-text');
        $rolePenulis->givePermissionTo('show-text');
    }
}
