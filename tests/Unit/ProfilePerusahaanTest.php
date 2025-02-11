<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Perusahaan\Models\profilePerusahaan;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProfilePerusahaanTest extends TestCase // Warisi Laravel TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_a_new_profile_perusahaan()
    {
        $data = [
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
        ];

        $profile = profilePerusahaan::create($data);

        $this->assertDatabaseHas('profile_perusahaans', $data);
        $this->assertNotNull($profile->id);
    }

    #[Test]
    public function it_can_update_a_profile_perusahaan()
    {
        $profile = profilePerusahaan::create([
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

        $updatedData = [
            'nama' => 'PT Maju Jaya Sejahtera',
            'alamat' => 'Jl. Merdeka No. 15',
            'no_telp' => '08123456700',
            'email' => 'contact@majujayasejahtera.com',
            'kode_pos' => '54321',
        ];

        $profile->update($updatedData);

        $this->assertDatabaseMissing('profile_perusahaans', [
            'nama' => 'PT Maju Jaya',
            'alamat' => 'Jl. Merdeka No. 10',
            'no_telp' => '08123456789',
            'email' => 'info@majujaya.com',
            'kode_pos' => '12345',
        ]);

        $this->assertDatabaseHas('profile_perusahaans', $updatedData);
    }
}
