<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Nopd;
use App\Models\User;
use App\Models\Lokasi;
use App\Models\Internet;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Modules\Perusahaan\Models\profilePerusahaan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\SewaMenyewa\Models\Lokasi as ModelsLokasi;

class LokasiTest extends TestCase
{
    use RefreshDatabase; // Membersihkan database setelah setiap pengujian

    /** @test */
    public function it_requires_all_fields_to_store_lokasi()
    {
         // Buat user dengan role admin
         $user = User::factory()->create();
         $role = Role::create(['name' => 'admin']);
         $user->assignRole($role);
 
         // Login sebagai user dengan role admin
         $this->actingAs($user);
        $response = $this->postJson(route('lokasi.store'), []);

        $response->assertStatus(422)
                 ->assertJson([
                     'status' => 'error',
                 ]);
    }

    /** @test */
    public function it_stores_lokasi_successfully()
    {
         // Buat user dengan role admin
         $user = User::factory()->create();
         $role = Role::create(['name' => 'admin']);
         $user->assignRole($role);
 
         // Login sebagai user dengan role admin
         $this->actingAs($user);
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
            'nama' => 'Gedung A',
            'alamat' => 'Jl. Merdeka No. 1',
            'phone' => '081234567890',
            'category' => 'office',
            'type' => 'mall',
            'status' => 'fadly_own',
            'luas' => 100,
            'harga' => 50000000,
            'pph' => 5000000,
            'ppn' => 1000000,
            'deposit' => 20000000,
            'pembayar_pbb' => 'fadly',
            'no_pbb' => '1234567890',
            'id_pln' => 'PLN123456',
            'daya' => '2200',
            'id_pdam' => 'PDAM12345',
            'denda_telat_bayar' => 500000,
            'denda_pembatalan' => 1000000,
            'denda_pengosongan' => 2000000,
            'nopd' => ['NOPD-001'],
            'bentuk' => ['Kotak'],
            'ukuran' => ['10X10'],
            'id_internet' => ['ISP001'],
            'speed_internet' => ['100Mbps'],
            'harga_internet' => [300000],
        ];

        $response = $this->postJson(route('lokasi.store'), $data);
        dump($response->json());

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Data Berhasil Ditambahkan',
                 ]);

        // Pastikan data lokasi tersimpan di database
        $this->assertDatabaseHas('lokasi', [
            'nama' => 'Gedung A',
            'alamat' => 'Jl. Merdeka No. 1',
        ]);

        // Pastikan data NOPD tersimpan
        $this->assertDatabaseHas('nopds', [
            'nopd' => 'NOPD-001',
            'bentuk' => 'Kotak',
            'ukuran' => '10x10',
        ]);

        // Pastikan data Internet tersimpan
        $this->assertDatabaseHas('internet', [
            'id_internet' => 'ISP001',
            'speed_internet' => '100Mbps',
            'harga_internet' => 300000,
        ]);
    }

    /** @test */
    public function it_updates_lokasi_successfully()
{
    // Buat user dengan role admin
    $user = User::factory()->create();
    $role = Role::create(['name' => 'admin']);
    $user->assignRole($role);

    // Login sebagai user dengan role admin
    $this->actingAs($user);
  

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

    
    $lokasi = ModelsLokasi::create([
       'uid_profile_perusahaan' => $profilePerusahaan->id,
            'nama' => 'Gedung A',
            'alamat' => 'Jl. Merdeka No. 1',
            'phone' => '081234567890',
            'category' => 'office',
            'type' => 'mall',
            'status' => 'fadly_own',
            'luas' => 100,
            'harga' => 50000000,
            'pph' => 5000000,
            'ppn' => 1000000,
            'deposit' => 20000000,
            'pembayar_pbb' => 'fadly',
            'no_pbb' => '1234567890',
            'id_pln' => 'PLN123456',
            'daya' => '2200',
            'id_pdam' => 'PDAM12345',
            'denda_telat_bayar' => 500000,
            'denda_pembatalan' => 1000000,
            'denda_pengosongan' => 2000000,
            'nopd' => ['NOPD-001'],
            'bentuk' => ['Kotak'],
            'ukuran' => ['10X10'],
            'id_internet' => ['ISP001'],
            'speed_internet' => ['100Mbps'],
            'harga_internet' => [300000],
    ]);

    // Data untuk update
    $updatedData = [
        'uid_profile_perusahaan' => $profilePerusahaan->id,
            'nama' => 'Gedung B',
            'alamat' => 'Jl. Merdeka No. 3',
            'phone' => '081234567890',
            'category' => 'office',
            'type' => 'mall',
            'status' => 'fadly_own',
            'luas' => 400,
            'harga' => 50000000,
            'pph' => 5000000,
            'ppn' => 1000000,
            'deposit' => 20000000,
            'pembayar_pbb' => 'fadly',
            'no_pbb' => '1234567890',
            'id_pln' => 'PLN123456',
            'daya' => '2200',
            'id_pdam' => 'PDAM12345',
            'denda_telat_bayar' => 500000,
            'denda_pembatalan' => 1000000,
            'denda_pengosongan' => 2000000,
            'nopd' => ['NOPD-001'],
            'bentuk' => ['Kotak'],
            'ukuran' => ['20X10'],
            'id_internet' => ['ISP001'],
            'speed_internet' => ['100Mbps'],
            'harga_internet' => [300000],
    ];

    $response = $this->putJson(route('lokasi.update', $lokasi->id), $updatedData);
    dump($response->json());
    $response->assertStatus(200)
    ->assertJson([
        'status' => true,
        'message' => 'Data Berhasil Diupdate', 
    ]);
    

   // Pastikan data lokasi tersimpan di database
   $this->assertDatabaseHas('lokasi', [
    'nama' => 'Gedung B',
    'alamat' => 'Jl. Merdeka No. 3',
]);

// Pastikan data NOPD tersimpan
$this->assertDatabaseHas('nopds', [
    'nopd' => 'NOPD-001',
    'bentuk' => 'Kotak',
    'ukuran' => '20x10',
]);

// Pastikan data Internet tersimpan
$this->assertDatabaseHas('internet', [
    'id_internet' => 'ISP001',
    'speed_internet' => '100Mbps',
    'harga_internet' => 300000,
]);

   
}
    
}
