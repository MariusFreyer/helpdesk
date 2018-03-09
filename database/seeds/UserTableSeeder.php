<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'User';
        $user->email = 'user@test.de';
        $user->password = Hash::make('password');
        $user->role = User::USER_ROLE;
        $user->save();

        $supporter = new User();
        $supporter->name = 'Supporter';
        $supporter->email = 'supporter@test.de';
        $supporter->password = Hash::make('password');
        $supporter->role = User::SUPPORTER_ROLE;
        $supporter->save();

        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@test.de';
        $admin->password = Hash::make('password');
        $admin->role = User::ADMIN_ROLE;
        $admin->save();
    }
}
