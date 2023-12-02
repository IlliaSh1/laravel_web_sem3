<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'admin',
            'email'=> 'admin@mail.ru',
            'password'=> Hash::make('asdfasdf'),
            'role'=> 'moderator'
        ]);

        User::create([
            'name' => 'Reader',
            'email'=> 'reader@mail.ru',
            'password'=> Hash::make('asdfasdf'),
            'role'=> 'reader'
        ]);
        
    }
}
