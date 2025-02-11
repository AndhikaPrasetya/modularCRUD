<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Modules\Perusahaan\Models\profilePerusahaan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'create-role', 'read-role', 'update-role', 'delete-role',
            'create-permission', 'read-permission', 'update-permission', 'delete-permission',
            'create-user', 'read-user', 'update-user', 'delete-user',
            'create-document', 'read-document', 'update-document', 'delete-document',
            'create-category', 'read-category', 'update-category', 'delete-category',
            'create-profilePerusahaan', 'read-profilePerusahaan', 'update-profilePerusahaan', 'delete-profilePerusahaan',
            'create-aktaPerusahaan', 'read-aktaPerusahaan', 'update-aktaPerusahaan', 'delete-aktaPerusahaan',
            'create-lokasi', 'read-lokasi', 'update-lokasi', 'delete-lokasi',
            'create-jenisDokumen', 'read-jenisDokumen', 'update-jenisDokumen', 'delete-jenisDokumen',
            'create-sewaMenyewa', 'read-sewaMenyewa', 'update-sewaMenyewa', 'delete-sewaMenyewa',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Update cache for permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create admin role and assign permissions
        DB::beginTransaction();
        try {
            $role = Role::create(['name' => 'admin']);
            $role->givePermissionTo(Permission::all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Seeding failed: ' . $e->getMessage());
        }

        // Create Super Admin user
        DB::beginTransaction();
        try {
            $admin = User::create([
                'name' => 'john doe',
                'email' => 'john@example.com',
                'password' => bcrypt('password'),
            ]);
            $admin->assignRole('admin');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Seeding failed: ' . $e->getMessage());
        }
        profilePerusahaan::create([
            'nama' => 'PT. ZAP',
            'alamat' => 'Belleza Shopping Arcade GF Unit SA 86 & 1st Floor Unit SA 86, Jl. Jend Soepono, North Grogol, Kebayoran Lama, South Jakarta City, Jakarta',
            'no_telp' => '0217992312',
            'email' => 'zap@zap.com',
            'kode_pos' => '12210',
            'no_domisili' =>'22113',
            'nama_domisili' => 'Jakarta',
            'alamat_domisili' => 'Belleza Shopping Arcade GF Unit SA 86 & 1st Floor Unit SA 86, Jl. Jend Soepono, North Grogol, Kebayoran Lama, South Jakarta City, Jakarta',
            'province_domisili' => 'DKI Jakarta',
            'kota_domisili' => 'Jakarta Selatan',
            'no_npwp' => '231231212',
            'nama_npwp' => 'zulu alpha papa',
            'alamat_npwp' => 'Belleza Shopping Arcade GF Unit SA 86 &
            1st Floor Unit SA 86, Jl. Jend Soepono,
            North Grogol, Kebayoran Lama, South Jakarta City, Jakarta',
        ]);
    }
}