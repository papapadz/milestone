<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Auth;
use App\Models\Log;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson() && Auth::user()) {
            if(Auth::user()->role == 'admin') {
                
                $user = Auth::user();
                $adminSession = [
                    'id'        => $user->id,
                    'firstname'  => $user->firstname,
                    'lastname'  => $user->lastname,
                ];
            
                $request->session()->put('admin', $adminSession);    
            } else if(Auth::user()->role == 'ceo') {
            
                    $user = Auth::user();
                    $ceoSession = [
                        'id'        => $user->id,
                        'firstname'  => $user->firstname,
                        'lastname'  => $user->lastname,
                    ];
            
                    $request->session()->put('ceo', $ceoSession);
            } else if(Auth::user()->role == 'manager') {
                            
                    $user = Auth::user();
                    $managerSession = [
                        'id'        => $user->id,
                        'firstname'  => $user->firstname,
                        'lastname'  => $user->lastname,
                    ];
            
                    $request->session()->put('manager', $managerSession);
            } else if(Auth::user()->role == 'employee'){
                            
                    $user = Auth::user();
                    $employeeSession = [
                        'id'        => $user->id,
                        'firstname'  => $user->firstname,
                        'lastname'  => $user->lastname,
                    ];
            
                    $request->session()->put('employee', $employeeSession);
            }
            
            Log::create([
                'user_id' => Auth::User()->id,
                'action' => 'login',
                'table' => 'users',
                'row_id' => Auth::User()->id
            ]);
            return route('home');
        }
    }
}
