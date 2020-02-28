<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = ['name', 'description', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = strtolower($value);
    }
}
