<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase; // Membersihkan database setiap pengujian

    /** @test */
    public function it_fails_validation_when_name_is_missing()
    {
        $request = new Request([
            'permission' => ['view_users']
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles',
            'permission' => 'required',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertEquals('The name field is required.', $validator->errors()->first('name'));
    }

    /** @test */
    public function it_creates_a_role_successfully()
    {
        // Buat permission sebelum melakukan pengujian
        Permission::create(['name' => 'view_users']);
        Permission::create(['name' => 'edit_users']);

        $request = new Request([
            'name' => 'Admin',
            'permission' => ['view_users', 'edit_users']
        ]);

        // Simulasi proses validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles',
            'permission' => 'required',
        ]);

        $this->assertFalse($validator->fails()); // Pastikan validasi tidak gagal

        // Simulasi penyimpanan role
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permission);

        // Pastikan role berhasil disimpan dalam database
        $this->assertDatabaseHas('roles', ['name' => 'Admin']);
    }

    /** @test */
public function it_updates_a_role_successfully()
{
    // Buat role dan permission
    Permission::create(['name' => 'view_users']);
    Permission::create(['name' => 'edit_users']);
    Permission::create(['name' => 'delete_users']);

    $role = Role::create(['name' => 'Admin']);
    $role->syncPermissions(['view_users', 'edit_users']);

    // Simulasi update request
    $request = new Request([
        'name' => 'Super Admin',
        'permission' => ['delete_users']
    ]);

    // Update role
    $role->update(['name' => $request->name]);
    $role->syncPermissions($request->permission);

    // Pastikan role berhasil diupdate
    $this->assertDatabaseHas('roles', ['name' => 'Super Admin']);

    // Pastikan role memiliki permission yang diperbarui
    $this->assertTrue($role->hasPermissionTo('delete_users'));
    $this->assertFalse($role->hasPermissionTo('view_users')); // Permission lama harus dihapus
}



}
