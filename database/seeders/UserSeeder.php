<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try{
            $admin = User::create([
                'name' => 'Super Admin',
                'email' => 'super-admin@example.com',
                'password' => bcrypt('password'),
            ]);
            $admin->assignRole('admin');

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            $this->command->error('Seeding failed: ' . $e->getMessage());
        }

       
    }
}
