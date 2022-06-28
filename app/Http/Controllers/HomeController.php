<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Task;
use Carbon\Carbon;

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
    public function index(Request $request)
    {
        $headers = [
            'datefrom' => Carbon::now()->toDateString(),
            'dateto' => Carbon::now()->toDateString(),
            'flag' => 1
        ];
        if(Auth::user()->role == 'admin'){
            
            if($request->has('datefrom') && $request->has('dateto') && $request->has('flag')) {
                $headers['datefrom'] = $request->datefrom;
                $headers['dateto'] = $request->dateto;
                $headers['flag'] = $request->flag;
            }
            $company = Company::get();

            return view('users.admin.dashboard', [
                'company' => $company,
                'headers' => $headers
            ]);
        }
        if(Auth::user()->role == 'ceo'){

            $user = Auth::user();

            $task = Task::where([['assigned_for', $user->id],['is_visible', true]])->get();

            return view('users.ceo.dashboard', [
                'task' =>  $task,
                'headers' => $headers
            ]);
        }
        if(Auth::user()->role == 'manager'){

            $user = Auth::user();

            $task = Task::where([['assigned_for', $user->id],['is_visible', true]])->get();

            return view('users.manager.dashboard',[
                'task' =>  $task,
                'headers' => $headers
            ]);
        }
        if(Auth::user()->role == 'employee'){

            $user = Auth::user();

            $task = Task::where('assigned_for', $user->id)->get();

            // dd($task);

            return view('users.employee.dashboard', [
                'task' =>  $task,
                'headers' => $headers
            ]);
        }
    }
}
