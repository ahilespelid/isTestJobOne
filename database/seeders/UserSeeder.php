<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //User::factory()->count(50)->create();
        DB::transaction(function()
        {
            for($fixture=0,$count=50; $fixture<$count; $fixture++){
                DB::table('users')->insert([
                    'id'            => Str::uuid(),
                    'last_name'     => Str::random(10),
                    'name'          => Str::random(10),
                    'middle_name'   => Str::random(10),
                    'email'         => Str::random(10).'@example.com',
                    'pass'          => Hash::make('password'),
                    'phone'         => rand(),
                    'created_at'    => $time = (new \DateTime())->format('Y-m-d H:i:s'),
                    'updated_at'    => $time,
                ]);
            }
        });
        DB::commit();
    }
}
