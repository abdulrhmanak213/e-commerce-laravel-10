<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $admin = User::query()->create([
            'first_name'=>'admin',
            'last_name'=>'admin',
            'email'=>'admin@gmail.com',
            'phone'=>'0999999999',
            'password'=>Hash::make('123456789'),
        ]);
        $admin->assignRole('admin');
        $admin->forceFill(['is_admin'=>1,'verified_at'=>Carbon::now()])->save();
        $admin->save();
    }
}
