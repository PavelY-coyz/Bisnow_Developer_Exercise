<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('password_resets')->delete();
        DB::table('news_items')->delete();
        DB::table('event_items')->delete();
        DB::table('images')->delete();
        DB::table('track_page_views')->delete();
        DB::table('summarize_tracking_data')->delete();

        $this->call('UsersTableSeeder');
        $this->command->info('Users Table Seeded');

        //create an instance of the Faker class for random value generation
        $faker = Faker::create();

        //List of image names : ie. "1.jpg"
        $imageNames = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];
        //shuffle the array for some randomness
        shuffle($imageNames);
        //an array we will fill by extracting from $imageNames
        $saveImageNames = [];

        //Lets populate our news_items table and save the image names that are used
        $news_items = [];
        for($i=0; $i<10; $i+=2) {
          $saveImageNames[] = array_shift($imageNames); //save it for Images table population
          $saveImageNames[] = array_shift($imageNames); //get another one
          $news_items[] = App\NewsItem::create([
            'title' => $faker->name, //just for a short string
            'html_body' => base64_encode("|div class \"container\"/|"
                              ."|img src='../images/".$saveImageNames[$i].".jpg' alt=\"MainPicture\"/|"
                              ."|br / /|"
                              .$faker->text
                              ."|br / /|"
                              ."|img src='../images/".$saveImageNames[$i+1].".jpg' alt=\"SecondPicture\"/|"
                              ."|/div/|"),
          ]);
        }

        //Now we have 10 elements in imageNames to relate images to event_items,
        //and 10 elements in saveImageNames that need to be related to news_items

        //populate images table with records that correspond to $news_items (news_items table)
        $images = [];
        for($i=0;$i<10;$i++) {
          $images[] = App\Images::create([
            'name' => $saveImageNames[$i],
          ]);
        }
        //setup the poly oneToMany relation (it cant be a many to many relation as far as I can see)
        for($i=0;$i<10;$i+=2) {
          ($i==0) ? $news_items[$i]->images()->saveMany([$images[$i], $images[$i+1]]) :
                    $news_items[$i/2]->images()->saveMany([$images[$i], $images[$i+1]]);
        }


        //Populate the event_items table
        $events = [];
        for($i=0; $i<10; $i++) {
          $events[] = App\EventItem::create([
            'name' => $faker->name,
            'description' => $faker->text,
            'event_date' => $faker->date,
          ]);
        }

        //populate images table with records that correspond to $events (event_items table)
        $images = [];
        for($i=0;$i<10;$i++) {
          $images[] = App\Images::create([
            'name' => $imageNames[$i],
          ]);
        }

        //setup the poly oneToMany relation (it cant be a many to many relation as far as I can see)
        for($i=0;$i<10;$i++) {
          $events[$i]->images()->save($images[$i]);
        }
    }
}
