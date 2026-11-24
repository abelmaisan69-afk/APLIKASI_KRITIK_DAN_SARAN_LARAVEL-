<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $fillable = ['nama', 'email', 'tipe', 'pesan', 'sudah_dibaca'];
}
