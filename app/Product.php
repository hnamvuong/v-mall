<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category_id', 'producer_id', 'image', 'description', 'amount', 'price'
    ];

    public function producers()
    {
        return $this->belongsTo('App\Producer');
    }

    public function categories()
    {
        return $this->belongsTo('App\Category');
    }
}
