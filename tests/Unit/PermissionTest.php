<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PermissionTest extends TestCase
{
    use RefreshDatabase; // Membersihkan database sebelum setiap pengujian

    /** @test */
    public function it_fails_validation_when_name_is_missing()
    {
        $request = new Request([]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertEquals('The name field is required.', $validator->errors()->first('name'));
    }

    /** @test */
    public function it_creates_a_permission_successfully()
    {
        // Simulasi request dengan nama permission
        $request = new Request([
            'name' => 'view_users'
        ]);

        // Simulasi validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        $this->assertFalse($validator->fails()); // Pastikan validasi tidak gagal

        // Simulasi penyimpanan permission
        $permission = Permission::create(['name' => $request->name]);

        // Pastikan permission berhasil disimpan dalam database
        $this->assertDatabaseHas('permissions', ['name' => 'view_users']);

        // Pastikan permission ID berhasil dibuat
        $this->assertNotNull($permission->id);
    }

    /** @test */
public function it_updates_a_permission_successfully()
{
    // Buat permission awal
    $permission = Permission::create(['name' => 'view_users']);

    // Simulasi request update
    $request = new Request([
        'name' => 'edit_users'
    ]);

    // Simulasi validasi
    $validator = Validator::make($request->all(), [
        'name' => 'required',
    ]);

    $this->assertFalse($validator->fails()); // Pastikan validasi tidak gagal

    // Update permission
    $permission->update(['name' => $request->name]);

    // Pastikan permission berhasil diupdate dalam database
    $this->assertDatabaseHas('permissions', ['name' => 'edit_users']);
    $this->assertDatabaseMissing('permissions', ['name' => 'view_users']); // Nama lama harus hilang
}


   
    
}
