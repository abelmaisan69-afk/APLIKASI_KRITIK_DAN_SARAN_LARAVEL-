<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewReply extends Model
{
    protected $fillable = ['review_id', 'user_id', 'balasan'];
public function review() { return $this->belongsTo(Review::class); }
public function admin()  { return $this->belongsTo(User::class, 'user_id'); }
}
