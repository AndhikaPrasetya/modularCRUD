<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase; // Membersihkan database setelah setiap pengujian

    /** @test */
    public function it_fails_validation_when_required_fields_are_missing()
    {
        $data = [
            'name' => '',
            'email' => '',
            'password' => '',
            'roles' => '',
            'image' => '',
        ];

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'roles' => 'required',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:3000',
        ]);

        $this->assertTrue($validator->fails());
    }

    /** @test */
    public function it_creates_a_user_successfully()
    {
        Storage::fake('public'); // Simulasi penyimpanan file

        // Buat role terlebih dahulu
        $role = Role::create(['name' => 'admin']);

        $image = UploadedFile::fake()->image('avatar.jpg'); // File gambar palsu
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'roles' => ['admin'],
            'image' => $image,
        ];

        // Simulasi validasi
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'roles' => 'required',
            'image' => 'required|file|mimes:jpg,jpeg,png|max:3000',
        ]);

        $this->assertFalse($validator->fails()); // Pastikan validasi tidak gagal

        // Simulasi penyimpanan user
        $fileName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('foto-profile', $fileName, 'public');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'image' => 'storage/foto-profile/' . $fileName,
        ]);

        $user->syncRoles($data['roles']);

        // Pastikan user tersimpan di database
        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com',
        ]);

        // Pastikan password terenkripsi
        $this->assertTrue(Hash::check('password123', $user->password));

        // Pastikan gambar tersimpan di lokasi yang benar
        Storage::disk('public')->assertExists('foto-profile/' . $fileName);

        // Pastikan role tersinkronisasi
        $this->assertTrue($user->hasRole('admin'));
    }
    /** @test */
public function it_updates_a_user_successfully()
{
    Storage::fake('public'); // Simulasi penyimpanan file

    // Buat user dan role terlebih dahulu
    $role = Role::create(['name' => 'admin']);
    $user = User::create([
        'name' => 'Old Name',
        'email' => 'oldemail@example.com',
        'password' => Hash::make('oldpassword'),
        'image' => 'storage/foto-profile/old_image.jpg',
    ]);
    $user->assignRole('admin');

    $newImage = UploadedFile::fake()->image('new_avatar.jpg'); // File gambar baru
    $updatedData = [
        'name' => 'New Name',
        'email' => 'newemail@example.com',
        'password' => '', // Password tidak diubah
        'roles' => ['admin'],
        'image' => $newImage,
    ];

    // Simulasi validasi
    $validator = Validator::make($updatedData, [
        'name' => 'required',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8',
        'roles' => 'required',
        'image' => 'nullable|file|mimes:jpg,jpeg,png|max:3000',
    ]);

    $this->assertFalse($validator->fails()); // Pastikan validasi berhasil

    // Jika ada gambar baru, simpan
    if ($updatedData['image']) {
        $fileName = time() . '.' . $newImage->getClientOriginalExtension();
        $newImage->storeAs('foto-profile', $fileName, 'public');
        $updatedData['image'] = 'storage/foto-profile/' . $fileName;
    } else {
        $updatedData['image'] = $user->image;
    }

    // Update user di database
    $user->update([
        'name' => $updatedData['name'],
        'email' => $updatedData['email'],
        'image' => $updatedData['image'],
    ]);

    // Jika ada password baru, update
    if (!empty($updatedData['password'])) {
        $user->update(['password' => Hash::make($updatedData['password'])]);
    }

    // Perbarui role
    $user->syncRoles($updatedData['roles']);

    // Pastikan user diperbarui di database
    $this->assertDatabaseHas('users', [
        'name' => 'New Name',
        'email' => 'newemail@example.com',
    ]);

    // Pastikan gambar diperbarui
    Storage::disk('public')->assertExists('foto-profile/' . $fileName);

    // Pastikan password tetap sama jika tidak diubah
    $this->assertTrue(Hash::check('oldpassword', $user->password));

    // Pastikan role diperbarui
    $this->assertTrue($user->hasRole('admin'));
}



}
