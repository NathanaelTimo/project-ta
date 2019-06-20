<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function item()
    {
        return $this->belongsTo('App\Models\Item', 'items_id', 'id');
    }
}