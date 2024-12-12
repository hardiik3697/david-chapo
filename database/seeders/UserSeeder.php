<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder{

    public function run(){
        $data = [
                    [
                        'firstname' => 'Super',
                        'lastname' => 'Admin',
                        'username' => 'super',
                        'phone' => '7897897891',
                        'email' => 'superadmin@example.com',
                        'role' => 'admin'
                    ],
                    [
                        'firstname' => 'Mitul',
                        'lastname' => 'admin',
                        'username' => 'mituladmin',
                        'phone' => '7897897892',
                        'email' => 'mitul@admin.com',
                        'role' => 'user'
                    ],
                    [
                        'firstname' => 'Hardik',
                        'lastname' => 'admin',
                        'username' => 'hardikadmin',
                        'phone' => '7897897893',
                        'email' => 'hardik@admin.com',
                        'role' => 'user'
                    ]
                ];

        foreach($data as $row){
            User::create([
                'firstname' => $row['firstname'],
                'lastname' => $row['lastname'],
                'username' => $row['username'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'password' => bcrypt('Admin@123'),
                'photo' => 'profile-pic.png',
                'role' => $row['role'],
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);
        }

        $file_to_upload = public_path().'/uploads/users/';
        if (!File::exists($file_to_upload))
            File::makeDirectory($file_to_upload, 0777, true, true);

        if(file_exists(public_path('/dummy/profile-pic.png')) && !file_exists(public_path('/uploads/users/profile-pic.png')) ){
            File::copy(public_path('/dummy/profile-pic.png'), public_path('/uploads/users/profile-pic.png'));
        }
    }
}
