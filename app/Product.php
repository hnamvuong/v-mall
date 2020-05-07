<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id', 'producer_id', 'image', 'description', 'amount', 'price'
    ];

    public function producer()
    {
        return $this->belongsTo('App\Producer');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
