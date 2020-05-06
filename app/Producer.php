<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    protected $fillable = [
        'name', 'logo', 'description'
    ];

    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
