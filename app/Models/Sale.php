<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function books()
    {
    	return $this->belongsTo('App\Models\Book', 'books_id', 'id');
    }
}
