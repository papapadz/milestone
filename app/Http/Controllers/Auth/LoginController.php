<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use App\Models\Company;
use App\Models\Employee;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function login()
    // {
    //     return view('auth.login');
    // } /*public function login()*/

    /**
     * Write code on Method
     *
     * @return response()
     */

    // public function postLogin(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required',
    //         'password' => 'required',
    //     ]);

    //     // $credentials = $request->all();
    //     // dd($credentials); 
        

    //     if (Auth::attempt($credentials)) {
    //         if(Auth::user()->role == 'admin'){
                
    //             $user = Auth::user();
    //             $adminSession = [
    //                 'id'        => $user->id,
    //                 'firstname'  => $user->firstname,
    //                 'lastname'  => $user->lastname,
    //             ];

    //             $request->session()->put('admin', $adminSession);
    //             return redirect('/');
    //         }
    //         if(Auth::user()->role == 'ceo'){

    //             $user = Auth::user();
    //             $ceoSession = [
    //                 'id'        => $user->id,
    //                 'firstname'  => $user->firstname,
    //                 'lastname'  => $user->lastname,
    //             ];

    //             $request->session()->put('ceo', $ceoSession);

    //             return redirect('/');
    //         }
    //         if(Auth::user()->role == 'manager'){
                
    //             $user = Auth::user();
    //             $managerSession = [
    //                 'id'        => $user->id,
    //                 'firstname'  => $user->firstname,
    //                 'lastname'  => $user->lastname,
    //             ];

    //             $request->session()->put('manager', $managerSession);
    //             return redirect('/');
    //         }
    //         if(Auth::user()->role == 'employee'){
                
    //             $user = Auth::user();
    //             $employeeSession = [
    //                 'id'        => $user->id,
    //                 'firstname'  => $user->firstname,
    //                 'lastname'  => $user->lastname,
    //             ];

    //             $request->session()->put('employee', $employeeSession);
    //             return redirect('/');
    //         }
    //     } else{
    //         return redirect("login");
    //     }
    
    // } /*public function postLogin*/

    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function logout()
    // {
    //     Session::flush();
    //     Auth::logout();

    //     return Redirect('login');
    // }
   
}
