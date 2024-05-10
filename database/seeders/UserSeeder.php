<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userObj = new User();
        $userObj->name = 'user';
        $userObj->last_name = 'user';
        $userObj->username = 'user';
        $userObj->gender = 'Male';
        $userObj->birthday = Carbon::createFromFormat('Y-m-d', '1990-01-01');
        $userObj->email = 'user@gmail.com';
        $userObj->country = 'Albania';
        $userObj->password = Hash::make('User1234');
        $userObj->role = 0;
        $userObj->save();

        $moderatorObj = new User();
        $moderatorObj->name = 'moderator';
        $moderatorObj->last_name = 'moderator';
        $moderatorObj->username = 'moderator';
        $moderatorObj->gender = 'Male';
        $moderatorObj->birthday = Carbon::createFromFormat('Y-m-d', '1990-01-01');
        $moderatorObj-> country = 'Albania';
        $moderatorObj->email = 'moderator@gmail.com';
        $moderatorObj->password = Hash::make('Moderator1234');
        $moderatorObj->role = 1;
        $moderatorObj->save();

        $adminObj = new User();
        $adminObj->name = 'admin';
        $adminObj->last_name = 'admin';
        $adminObj->username = 'admin';
        $adminObj->gender = 'Male';
        $adminObj->birthday = Carbon::createFromFormat('Y-m-d', '1990-01-01');
        $adminObj->country = 'Albania';
        $adminObj->email = 'admin@gmail.com';
        $adminObj->password = Hash::make('Admin1234');
        $adminObj->role = 2;
        $adminObj->save();
    }
}
