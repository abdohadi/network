<?php

use App\Group;
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

        $me = factory('App\User')->create(['email'=>'a@a.com', 'password'=>bcrypt('aaaaaaaa'), 'name'=>'user']);
        factory('App\Post', 10)->create(['user_id' => $me->id]);
        factory('App\Group', 5)->create(['user_id' => $me->id])->each(function ($group) use ($me) {
            $group->assignAdmin($me);
        });
        
        $users = factory('App\User', 40)->create()->each(function ($user) use ($me) {
            factory('App\Post', 5)->create(['user_id' => $user->id]);
           
            if ($user->id <= 20) {
                $group = factory('App\Group')->create(['user_id' => $user->id]);
                $group->assignAdmin($user);

                $group->join($me);
                if ($user->id <= 10) {
                    $group->acceptRequest($me);
                }
                
                $user->sendFriendRequest($me);
            }

            $me->ownedGroups->each(function ($group) use ($user) {
                $group->addMember($user);
            });
        });
    }
}
	