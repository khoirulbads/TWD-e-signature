<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'SuperAdmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('Superadmin12345'),
            'role' => 1,
            'unique_id' => Uuid::uuid4(),
        ]);


        DB::table('users')->insert([
            'id' => Uuid::uuid4(),
            'name' => 'Signer',
            'email' => 'signer@gmail.com',
            'password' => Hash::make('Signer12345'),
            'role' => 2,
            'unique_id' => Uuid::uuid4(),
            
        ]);

        // DB::table('settings')->insert([
        //     'id' => Uuid::uuid4(),
        //     'signer_name' => NULL,
        //     'location' => NULL,
        //     'department' => NULL,
        //     'signature' => NULL,
        //     'paraf' => NULL,
        // ]);
    }
}
