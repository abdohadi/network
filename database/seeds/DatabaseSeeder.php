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
        // $this->call(UsersTableSeeder::class);

        $user = factory('App\User')->create(['email'=>'a@a.com', 'password'=>bcrypt('aaaaaaaa'), 'name'=>'user']);
        $user->posts()->save(factory('App\Post')->create());
        
        factory('App\User', 10)->create()->each(function ($user) {
            $user->posts()->save(factory('App\Post')->create());
            $user->groups()->save(factory('App\Group')->create());
        });
    }
}
	