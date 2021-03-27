<?php

namespace App\Models\Logs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogUserSession extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
