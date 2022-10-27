<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    
    public function run()
    {
        $faker=Faker::create();
        $adminRole=Role::create(['name'=>'admin','display_name'=>'Administrator','description'=>'System Administrator','allowed_route'=>'admin']);
        $editorRole=Role::create(['name'=>'editor','display_name'=>'Supervisor','description'=>'System Supervisor','allowed_route'=>'admin']);
        $userRole=Role::create(['name'=>'user','display_name'=>'User','description'=>'Normal User','allowed_route'=>null]);

        $admin=User::create([
            'name'=>'Admin',
            'username'=>'admin',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('123123123'),
            'mobile'=>'01149534772',
            'email_verified_at'=>Carbon::now(),
            'status'=>1,
        ]);
        $admin->attachRole($adminRole);

        $editor=User::create([
            'name'=>'Editor',
            'username'=>'editor',
            'email'=>'editor@editor.com',
            'password'=>bcrypt('123123123'),
            'mobile'=>'01149534773',
            'email_verified_at'=>Carbon::now(),
            'status'=>1,
        ]);
        $editor->attachRole($editorRole);

        $user1=User::create([
            'name'=>'ali',
            'username'=>'ali',
            'email'=>'ali@ali.com',
            'password'=>bcrypt('123123123'),
            'mobile'=>'01149534774',
            'email_verified_at'=>Carbon::now(),
            'status'=>1,
        ]);
        $user1->attachRole($userRole);
        $user2=User::create([
            'name'=>'khaled',
            'username'=>'khaled',
            'email'=>'khaled@khaled.com',
            'password'=>bcrypt('123123123'),
            'mobile'=>'01149534775',
            'email_verified_at'=>Carbon::now(),
            'status'=>1,
        ]);
        $user2->attachRole($userRole);
        $user3=User::create([
            'name'=>'mohammed',
            'username'=>'mohammed',
            'email'=>'mohammed@mohammed.com',
            'password'=>bcrypt('123123123'),
            'mobile'=>'01149534776',
            'email_verified_at'=>Carbon::now(),
            'status'=>1,
        ]);
        $user3->attachRole($userRole);

        for ($i=0; $i < 10; $i++) { 
            $user=User::create([
            'name'=>$faker->name,
            'username'=>$faker->userName,
            'email'=>$faker->email,
            'password'=>bcrypt('123123123'),
            'mobile'=>'011'.random_int(10000000, 99999999),
            'email_verified_at'=>Carbon::now(),
            'status'=>1,
        ]);
            $user->attachRole($userRole);

        }
    }

}
