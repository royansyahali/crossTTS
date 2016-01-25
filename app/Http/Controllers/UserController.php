<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User;

class UserController extends Controller
{
    public function show($username){
        $user = User::findByUserName($username);
        
        return view('users.show', compact('user'));
    }
}
