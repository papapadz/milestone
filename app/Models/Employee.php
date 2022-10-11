<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Magros\Encryptable\Encryptable;

class Employee extends Model
{
    use HasFactory, Encryptable;

    protected $encryptable = [ 'contact_no', 'address'];
    protected $fillable = ['user_id','company_id','age','contact_no','address','position','gender','active'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
