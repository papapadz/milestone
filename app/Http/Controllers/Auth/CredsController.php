<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use PDF;
use DB;

class PDFController extends Controller
{
    public function getAllUser()
    {
        $user = User::all();
        
        return view('info',compact('user'));
    }

}