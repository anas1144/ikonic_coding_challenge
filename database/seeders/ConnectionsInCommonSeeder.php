<?php

namespace Database\Seeders;

use App\Models\Request;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class ConnectionsInCommonSeeder extends Seeder
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
            foreach ($user->pendingRequestsFrom()->limit(10)->get() as $user_request){
                $user_request->pivot->update(['accepted'=>1]);
                Request::updateOrCreate(
                    [
                        'user_id'=>$user_request->pivot->request_id,
                        'request_id'=> $user_request->pivot->user_id,
                        'accepted' => 1
                    ],
                    [
                        'user_id'=>$user_request->pivot->request_id,
                        'request_id'=> $user_request->pivot->user_id,
                        'accepted' => 1
                    ]
                );
            }
        }
    }
}
