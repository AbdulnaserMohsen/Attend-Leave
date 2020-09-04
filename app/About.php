<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = 
    [
        'name_ar','name_en','description_ar', 'description_en', 'image',
    ];
}
