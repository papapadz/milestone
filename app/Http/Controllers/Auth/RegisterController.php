<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use Illuminate\Support\Str;
use App\Mail\NotifyMail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    public function showRegistrationForm() {

        return view('auth.register')->with('company',Company::orderBy('name')->get());
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => 'required',
            'lastname' => 'required',
            'role' => 'required',
            'email' => 'email|required|unique:users',
            'company' => 'required',
            'age' => 'required|numeric|min:18',
            'contact_no' => 'required|min:11',
            'address' => 'required',
            'gender' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $autoPassword = Str::random(6);
        $user = new User;
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        $user->password = app('hash')->make($autoPassword);
        $user->save();

        $employee = new Employee;
        $employee->user_id = $user->id;
        $employee->company_id = $data['company'];
        $employee->age = $data['age'];
        $employee->contact_no = $data['contact_no'];
        $employee->address = $data['address'];
        $employee->position = $user->role;
        $employee->gender = $data['gender'];
        $employee->save();

        $details = [
            'title' => 'Registration Success',
            'message' => 'Thank you for registering your account, please login using your registered email address '.$user->email.' and this password '.$autoPassword.' .'
        ];

        \Mail::to($user->email)->send(new NotifyMail($details));
        
        return $user;
    }
}
