<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = ['name', 'description'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
