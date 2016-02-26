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
        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1');
        DB::table('roles')->insert([
            'name'  => 'admin',
            'desc'  => 'Администратор сайта'
        ]);
        DB::table('roles')->insert([
            'name'  => 'partner',
            'desc'  => 'Партнер'
        ]);
        DB::table('users')->delete();
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        $user = new \App\User([
            'name'              => 'admin',
            'email'             => 'admin@mail.me',
            'password'          => bcrypt('admin'),
            'visibility_name'   => 'Администратор',
        ]);
        $user->save();
        $role = \App\Role::where('name', 'admin')->first();
        $user->roles()->attach($role->id);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
