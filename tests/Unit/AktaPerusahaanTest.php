<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Directors;
use Illuminate\Support\Str;
use App\Models\ShareHolders;
use App\Models\AktaPerusahaan;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use App\Models\AttachmentAktaPerusahaan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Perusahaan\Models\profilePerusahaan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Perusahaan\Models\AktaPerusahaan as ModelsAktaPerusahaan;

class AktaPerusahaanTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_fails_validation_when_required_fields_are_missing()
    {
          // Buat user dengan role admin
          $user = User::factory()->create();
          $role = Role::create(['name' => 'admin']);
          $user->assignRole($role);
  
          // Login sebagai user dengan role admin
          $this->actingAs($user);
        $response = $this->postJson(route('aktaPerusahaan.store'), []); // Kirim request kosong
        
        $response->assertStatus(422)  // Harus gagal validasi (422 Unprocessable Entity)
                 ->assertJsonValidationErrors([
                     'uid_profile_perusahaan', 'nama_akta', 'kode_akta',
                     'no_doc', 'tgl_terbit', 'nama_notaris', 'sk_kemenkum_ham', 'status'
                 ]);
    }

    /** @test */
    public function it_stores_akta_perusahaan_successfully()
    {
          // Buat user dengan role admin
          $user = User::factory()->create();
          $role = Role::create(['name' => 'admin']);
          $user->assignRole($role);
  
          // Login sebagai user dengan role admin
          $this->actingAs($user);
        Storage::fake('public'); // Simulasi penyimpanan file
        //create profile perusahaan 
        $profilePerusahaan = profilePerusahaan::create([
            'id' => Str::uuid(),
            'nama' => 'PT Maju Jaya',
            'alamat' => 'Jl. Merdeka No. 10',
            'no_telp' => '08123456789',
            'email' => 'info@majujaya.com',
            'kode_pos' => '12345',
            'no_domisili' => 'DOM-001',
            'nama_domisili' => 'Surat Domisili Maju Jaya',
            'alamat_domisili' => 'Jl. Domisili No. 5',
            'province_domisili' => 'DKI Jakarta',
            'kota_domisili' => 'Jakarta Pusat',
            'no_npwp' => '99.999.999.9-999.999',
            'nama_npwp' => 'PT Maju Jaya',
            'alamat_npwp' => 'Jl. Pajak No. 3'
        ]);

        
        $data = [
            'uid_profile_perusahaan' => $profilePerusahaan->id,
            'nama_akta' => 'Akta Perusahaan Contoh',
            'kode_akta' => 'AK12345',
            'no_doc' => 'DOC-98765',
            'tgl_terbit' => '2024-01-01',
            'nama_notaris' => 'Budi Notaris',
            'sk_kemenkum_ham' => 'SK-2024-XYZ',
            'status' => 'active',
            'file_path' => [UploadedFile::fake()->create('document.pdf', 500)], // File simulasi
            'nama_direktur' => ['John Doe'],
            'jabatan' => ['CEO'],
            'durasi_jabatan' => [1],
            'pemegang_saham' => ['Investor 1'],
            'jumlah_saham' => [1000],
            'saham_persen' => [50],
        ];

        $response = $this->postJson(route('aktaPerusahaan.store'), $data);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Data Berhasil Ditambahkan',
                 ]);

        $this->assertDatabaseHas('akta_perusahaans', [
            'nama_akta' => 'Akta Perusahaan Contoh',
            'kode_akta' => 'AK12345',
        ]);

        $this->assertDatabaseHas('directors', [
            'nama_direktur' => 'John Doe',
            'jabatan' => 'CEO',
        ]);

        $this->assertDatabaseHas('shareholders', [
            'pemegang_saham' => 'Investor 1',
            'jumlah_saham' => 1000,
            'saham_persen' => 50,
        ]);

        $this->assertDatabaseCount('attachment_akta_perusahaans', 1);
    }
/** @test */
    public function it_updates_akta_perusahaan_successfully()
{
    // Buat user dengan role admin
    $user = User::factory()->create();
    $role = Role::create(['name' => 'admin']);
    $user->assignRole($role);

    // Login sebagai user dengan role admin
    $this->actingAs($user);
    Storage::fake('public'); // Simulasi penyimpanan file

    // Buat profile perusahaan
    $profilePerusahaan = profilePerusahaan::create([
        'id' => Str::uuid(),
        'nama' => 'PT Maju Jaya',
        'alamat' => 'Jl. Merdeka No. 10',
        'no_telp' => '08123456789',
        'email' => 'info@majujaya.com',
        'kode_pos' => '12345',
        'no_domisili' => 'DOM-001',
        'nama_domisili' => 'Surat Domisili Maju Jaya',
        'alamat_domisili' => 'Jl. Domisili No. 5',
        'province_domisili' => 'DKI Jakarta',
        'kota_domisili' => 'Jakarta Pusat',
        'no_npwp' => '99.999.999.9-999.999',
        'nama_npwp' => 'PT Maju Jaya',
        'alamat_npwp' => 'Jl. Pajak No. 3'
    ]);

    // Buat data akta perusahaan
    $akta = ModelsAktaPerusahaan::create([
        'uid_profile_perusahaan' => $profilePerusahaan->id,
            'nama_akta' => 'Akta Perusahaan Contoh',
            'kode_akta' => 'AK12345',
            'no_doc' => 'DOC-98765',
            'tgl_terbit' => '2024-01-01',
            'nama_notaris' => 'Budi Notaris',
            'sk_kemenkum_ham' => 'SK-2024-XYZ',
            'status' => 'expired',
            'file_path' => [UploadedFile::fake()->create('document.pdf', 500)], // File simulasi
            'nama_direktur' => ['John Doe'],
            'jabatan' => ['CEO'],
            'durasi_jabatan' => [1],
            'pemegang_saham' => ['Investor 1'],
            'jumlah_saham' => [1000],
            'saham_persen' => [50],
    ]);

    // Data untuk update
    $updatedData = [
        'nama_akta' => 'Akta Perusahaan Baru',
        'kode_akta' => 'AK12345',
        'no_doc' => 'DOC-98765',
        'tgl_terbit' => '2024-01-01',
        'nama_notaris' => 'Budi Notaris',
        'sk_kemenkum_ham' => 'SK-2024-XYZ',
        'status' => 'active',
        'file_path' => [UploadedFile::fake()->create('updated_document.pdf', 500)],
        'nama_direktur' => ['Jane Doe'],
        'jabatan' => ['CFO'],
        'durasi_jabatan' => [2],
        'pemegang_saham' => ['Investor 2'],
        'jumlah_saham' => [2000],
        'saham_persen' => [60],
    ];

    $response = $this->putJson(route('aktaPerusahaan.update', $akta->id), $updatedData);

    $response->assertStatus(200)
    ->assertJson([
        'status' => true,
        'message' => 'Data Berhasil diperbarui', 
    ]);
    

    $this->assertDatabaseHas('akta_perusahaans', [
        'id' => $akta->id,
        'nama_akta' => 'Akta Perusahaan Baru',
        'kode_akta' => 'AK12345',
    ]);

    $this->assertDatabaseHas('directors', [
        'nama_direktur' => 'Jane Doe',
        'jabatan' => 'CFO',
    ]);

    $this->assertDatabaseHas('shareholders', [
        'pemegang_saham' => 'Investor 2',
        'jumlah_saham' => 2000,
        'saham_persen' => 60,
    ]);

    $this->assertDatabaseCount('attachment_akta_perusahaans', 1);
}

}
