<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToMill extends Model
{
    use HasFactory;
    protected $table = 'to_mill';
    protected $fillable = ['product_id', 'company_id'];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function rice() {
        return $this->hasOne(Rice::class,'mill_id','id');
    }

    public function darak() {
        return $this->hasOne(Darak::class,'mill_id','id');
    }
}
