<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Page;
use Faker\Factory as Faker;
class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        $faker=Faker::create();
        Page::create([
                'title'=>'About Us' ,
                'description'=>$faker->paragraph(),
                'status'=>1,
                // 'slug'=>$fakeer->
                'post_type'=>'page',
                'comment_able'=>1,
                'user_id'=>1,
                'category_id'=>1,
                
            ]);


                 Page::create([
                'title'=>'Our Vision' ,
                'description'=>$faker->paragraph(),
                'status'=>1,
                // 'slug'=>$fakeer->
                'post_type'=>'page',
                'comment_able'=>1,
                'user_id'=>1,
                'category_id'=>1,
                ]);
    }
}
