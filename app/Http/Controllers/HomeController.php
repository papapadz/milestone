<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\PalayVariant;
use DB;

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
        $user = Auth::user();
        if($user->login_attempt==0) {

            $token = Str::random(60);
            $user = User::find(Auth::User()->id);
            $user->remember_token = $token;
            $user->save();

            DB::table(config('auth.passwords.users.table'))->where('email',$user->email)->delete();
            DB::table(config('auth.passwords.users.table'))->insert([
                'email' => $user->email, 
                'token' => bcrypt($token),
                'created_at' => Carbon::now()
            ]);

            return redirect()->route('password.reset',[
                'token' => $token,
                'email' => Auth::User()->email
            ]);
        }

        $user->login_attempt = $user->login_attempt + 1;
        $user->save();
       
        $headers = [
            'datefrom' => Carbon::now()->toDateString(),
            'dateto' => Carbon::now()->toDateString(),
            'flag' => 1,
            'variant' => "0"
        ];
        if(Auth::user()->role == 'admin'){
            
            if($request->has('datefrom') && $request->has('dateto') && $request->has('flag')) {
                $headers['datefrom'] = $request->datefrom;
                $headers['dateto'] = $request->dateto;
                $headers['flag'] = $request->flag;
                $headers['variant'] = strval($request->variant);
            }
            $company = Company::get();

            return view('users.admin.dashboard', [
                'company' => $company,
                'headers' => $headers,
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

    public function filter(Request $request) {
        switch($request->flag) {
            case 1: case 2:
                return PalayVariant::select('id','variant')->get();
            case 3: case 4:
                return Company::select('id','name')->get();
        }
    }
}
