<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewCategory extends Model
{
    protected $fillable = ['nama'];
public function reviews() { return $this->hasMany(Review::class); }
}
