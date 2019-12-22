<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' => 'João',
            'email' => 'joao@gmail.com',
            'password' => bcrypt('123123')
        ]);

        $post = \App\Post::create([
            'user_id' => $user->id,
            'title' => 'Olá Dev',
            'description' => '<p>Esse é um post de teste</p>'
        ]);
        
    }
}
