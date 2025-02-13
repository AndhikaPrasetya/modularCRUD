<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lokasi;
use App\Models\SewaMenyewa;
use Illuminate\Support\Str;
use App\Models\JenisDokumen;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Perusahaan\Models\profilePerusahaan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\SewaMenyewa\Models\Lokasi as ModelsLokasi;
use Modules\SewaMenyewa\Models\SewaMenyewa as ModelsSewaMenyewa;
use Modules\SewaMenyewa\Models\JenisDokumen as ModelsJenisDokumen;

class SewaMenyewaTest extends TestCase
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
        $response = $this->postJson(route('sewaMenyewa.store'), []);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validasi gagal',
            ])
            ->assertJsonStructure(['errors']);
    }

    /** @test */
    public function it_successfully_stores_data_when_input_is_valid()
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

        $jenisDokumen = ModelsJenisDokumen::create([
            'nama_jenis_dokumen' => 'KTP',
        ]);

        $validData = [
            'lokasi_id' => $lokasi->id,
            'jenis_dokumen_id' => $jenisDokumen->id,
            'tentang' => $this->faker->sentence,
            'no_dokumen' => 'DOC123',
            'nama_notaris' => $this->faker->name,
            'tanggal_dokumen' => now()->toDateString(),
            'sign_by' => $this->faker->name,
            'nama_pemilik_awal' => $this->faker->name,
            'sewa_awal' => now()->subYear()->toDateString(),
            'sewa_akhir' => now()->addYear()->toDateString(),
            'sewa_grace_period' => '2 bulan',
            'sewa_handover' => now()->toDateString(),
            'no_sertifikat' => 'CERT12345',
            'jenis_sertifikat' => 'HGB',
            'tgl_sertifikat' => now()->toDateString(),
            'tgl_akhir_sertifikat' => now()->addYears(5)->toDateString(),
        ];

        $response = $this->postJson(route('sewaMenyewa.store'), $validData);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
            ])
            ->assertJsonStructure(['sewaId']);

        $this->assertDatabaseHas('sewa_menyewa', [
            'lokasi_id' => $validData['lokasi_id'],
            'no_dokumen' => $validData['no_dokumen'],
        ]);
    }





    /** @test */
    public function it_successfully_updates_data_when_input_is_valid()
    {
        // Buat user dengan role admin
        $user = User::factory()->create();
        $role = Role::create(['name' => 'admin']);
        $user->assignRole($role);
    
        // Login sebagai user dengan role admin
        $this->actingAs($user);
    
        // Buat profil perusahaan dan lokasi
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
    
        $jenisDokumen = ModelsJenisDokumen::create([
            'nama_jenis_dokumen' => 'KTP',
        ]);
        $validData =[
            'lokasi_id' => $lokasi->id,
            'jenis_dokumen_id' => $jenisDokumen->id,
            'tentang' => 'Perjanjian Sewa Lama',
            'no_dokumen' => 'DOC123',
            'nama_notaris' => 'Notaris Lama',
            'tanggal_dokumen' => now()->subYears(2)->toDateString(),
            'sign_by' => 'Pemilik Lama',
            'nama_pemilik_awal' => 'Nama Lama',
            'sewa_awal' => now()->subYears(2)->toDateString(),
            'sewa_akhir' => now()->addYear()->toDateString(),
            'sewa_grace_period' => '1 bulan',
            'sewa_handover' => now()->subMonths(6)->toDateString(),
            'no_sertifikat' => 'CERT12345',
            'jenis_sertifikat' => 'SHM',
            'tgl_sertifikat' => now()->subYears(5)->toDateString(),
            'tgl_akhir_sertifikat' => now()->addYears(10)->toDateString(),
        ];

        // Buat data awal
        $sewaMenyewa = ModelsSewaMenyewa::create($validData);
    
        // Data baru untuk update
        $updateData = [
            'lokasi_id' => $lokasi->id,
            'jenis_dokumen_id' => $jenisDokumen->id,
            'tentang' => 'Perjanjian Sewa Baru',
            'no_dokumen' => 'DOC456',
            'nama_notaris' => 'Notaris Baru',
            'tanggal_dokumen' => now()->toDateString(),
            'sign_by' => 'Pemilik Baru',
            'nama_pemilik_awal' => 'Nama Baru',
            'sewa_awal' => now()->toDateString(),
            'sewa_akhir' => now()->addYears(2)->toDateString(),
            'sewa_grace_period' => '3 bulan',
            'sewa_handover' => now()->addMonths(1)->toDateString(),
            'no_sertifikat' => 'CERT67890',
            'jenis_sertifikat' => 'HGB',
            'tgl_sertifikat' => now()->toDateString(),
            'tgl_akhir_sertifikat' => now()->addYears(5)->toDateString(),
        ];
        dump($validData);
    
        // Kirim request update
        $response = $this->putJson(route('sewaMenyewa.update', $sewaMenyewa->id), $updateData);
        dump($response->json());
        // Cek respons
        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Data berhasil diupdate',
            ]);
    
        // Pastikan data telah diperbarui di database
        $this->assertDatabaseHas('sewa_menyewa', [
            'id' => $sewaMenyewa->id,
            'tentang' => $updateData['tentang'],
            'no_dokumen' => $updateData['no_dokumen'],
        ]);
    }
    
}
