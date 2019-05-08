<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $guarded = ['id'];

    public function books()
    {
    	return $this->hasMany('App\Models\Book');
    }
}
