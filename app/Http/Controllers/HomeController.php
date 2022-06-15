<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Task;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->role == 'admin'){
            $company = Company::get();

            return view('users.admin.dashboard', [
                'company' => $company
            ]);
        }
        if(Auth::user()->role == 'ceo'){

            $user = Auth::user();

            $task = Task::where('assigned_for', $user->id)->get();

            return view('users.ceo.dashboard', [
                'task' =>  $task,
            ]);
        }
        if(Auth::user()->role == 'manager'){

            $user = Auth::user();

            $task = Task::where('assigned_for', $user->id)->get();

            return view('users.manager.dashboard',[
                'task' =>  $task,
            ]);
        }
        if(Auth::user()->role == 'employee'){

            $user = Auth::user();

            $task = Task::where('assigned_for', $user->id)->get();

            // dd($task);

            return view('users.employee.dashboard', [
                'task' =>  $task,
            ]);
        }
    }
}
