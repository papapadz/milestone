<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function userLists(Request $request)
    {
        $data = [
            'users'    => User::all()
        ];

        return view('users.list', $data);
    }       /* userLists() */
}
