<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    protected $fillable = [
        'name', 'logo', 'description'
    ];

    public function product()
    {
        return $this->hasMany('App\Product');
    }
}
