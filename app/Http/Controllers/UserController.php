<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Jobs\billUsers;


class UserController extends Controller
{


    public function billUsers(){
        $users = User::all();
        foreach($users as $user){
            $billing = billUsers::dispatch($user);
            
            
        }
        return "Billed users successfully";
       
    }
}
