<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PmUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userList = [
            [
                'name' => 'หน่วยยาเส้นภูมิภาค',
                'username' => 'PM01',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 51080192,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'กองผลิตยาเส้น',
                'username' => 'PM02',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 61000200,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'หน่วยผลิต FOIL',
                'username' => 'PM03',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 32040400,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'กองพิมพ',
                'username' => 'PM04',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 30010300,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'กองพิมพ์ สาขาโรจนะ',
                'username' => 'PM05',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 30010700,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'กองการยาเส้นพอง',
                'username' => 'PM06',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 32000300,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'กองผลิตยาเส้นพอง',
                'username' => 'PM07',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 61000300,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'ยาเส้นไม่ปรุง',
                'username' => 'PM08',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 32030400,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'หน่วยบรรจุภูมิภาค',
                'username' => 'PM09',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 51080193,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'กองผลิตก้นกรอง',
                'username' => 'PM10',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 62000300,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'กองการยาเส้นพอง สาขาโรจนะ',
                'username' => 'PM11',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 32000600,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'กองมวนและบรรจุ',
                'username' => 'PM12',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 62000200,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
            [
                'name' => 'กองทดลอง',
                'username' => 'PM13',
                'email' => 'mcr@test.com',
                'email_verified_at' => now(),
                'password' => bcrypt('welcome'),
                'remember_token' => \Str::random(10),
                'department_code' => 31000400,
                'last_updated_by' => -1,
                'created_by' => -1,
            ],
        ];

        \App\Models\User::insert($userList);
    }
}
