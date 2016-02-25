<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();
        DB::table('roles')->insert([
            'name'  => 'admin',
            'desc'  => 'Администратор сайта'
        ]);
        DB::table('roles')->insert([
            'name'  => 'partner',
            'desc'  => 'Партнер'
        ]);
        DB::table('users')->delete();
        $user = new \App\User([
            'name'              => 'admin',
            'email'             => 'admin@mail.me',
            'password'          => bcrypt('admin'),
            'visibility_name'   => 'Администратор',
        ]);
        $user->save();
        $role = \App\Role::where('name', 'admin')->first();
        $user->roles()->attach($role->id);
    }
}
