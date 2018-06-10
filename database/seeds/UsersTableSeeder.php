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
      //populate the users table

      //Lets me an anonymous user to act as guest
      DB::table('users')->insert([
        'name' => 'Anonymous',
        'id' => '1',
        'email' => 'Anonymous@example.com',
        'password' => bcrypt('secret'),
      ]);
      //Ill put myself in first, so i dont have to register
      DB::table('users')->insert([
        'name' => 'pavel',
        'email' => 'yartsevpavel@gmail.com',
        'password' => bcrypt('secret'),
      ]);

      //make 10 random users
      for($i=0; $i<10;$i++) {
        DB::table('users')->insert([
          'name' => str_random(10),
          'email' => str_random(10).'@gmail.com',
          'password' => bcrypt('secret'),
        ]);
      }
    }
}
