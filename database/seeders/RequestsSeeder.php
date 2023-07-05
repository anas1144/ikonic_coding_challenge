<?php

namespace Database\Seeders;

use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class RequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::all() as $user){
            //sent_request
            for ($i = 0; $i <=15; $i++){
                $random_user = User::where('id','!=',Auth::id())->inRandomOrder()->first();
                Request::updateOrCreate(
                    [
                        'user_id'=>$user->id,
                        'request_id'=> $random_user->id,
                        'accepted' => 0
                    ],
                    [
                        'user_id'=>$user->id,
                        'request_id'=> $random_user->id,
                        'accepted' => 0
                    ]
                );
            }
           //Received_request
            for ($i = 0; $i <=15; $i++){
                $random_user = User::where('id','!=',Auth::id())->inRandomOrder()->first();
                Request::updateOrCreate(
                    [
                        'user_id'=>$random_user->id,
                        'request_id'=> $user->id,
                        'accepted' => 0
                    ],
                    [
                        'user_id'=>$random_user->id,
                        'request_id'=> $user->id,
                        'accepted' => 0
                    ]
                );
            }
        }

    }
}
