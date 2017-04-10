<?php

use Illuminate\Database\Seeder;

class UserTodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 20)->create()->each(function ($u) {
	        $u->todos()->save(factory(App\Todo::class)->make());
	    });
    }
}
