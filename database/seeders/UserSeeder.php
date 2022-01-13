<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $projects=Project::select('id')->get()->toArray();

        for ($i = 1; $i < 4;$i++){
            $user = new User([
                'name'=> 'user_'.$i,
                'email'=> 'email_'.$i.'@cc.com',
                'login'=> 'test_'.$i,
                'password'=> Hash::make('1234567_'.$i),
                'id_project'=>$projects[rand(0,count($projects)-1)]['id']
                ]);
            $user->save();
        }
    }
}
