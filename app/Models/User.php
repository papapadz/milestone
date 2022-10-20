<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;
use Magros\Encryptable\Encryptable;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, Encryptable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $encryptable = [ 'email', 'firstname' , 'lastname'];

    protected $fillable = [
        'email',
        'firstname',
        'lastname',
        'email_verified_at',
        'password',
        'role',
        'login_attempt',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function employee() {
        return $this->hasOne(Employee::class,'user_id','id');
    }
}
